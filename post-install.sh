#!/usr/bin/env bash

RED='\033[0;31m'
ORANGE='\033[0;33m'
RESET='\033[0m' # No Color

# Yarn Install and compile assets
function compile_assets(){
    cd ./wp-content/themes/$site_slug/ || exit
    [[ -z nvm ]] && nvm use --lts
    composer install
    yarn && yarn build
    cd -
}

function update_theme_info() {
  cd ./wp-content/themes/$site_slug/ || exit
  sed -i '' -e "s|Theme Name:         Roboter|Theme Name:         $site_name|g" style.css
  cd -
}

function update_browsersync_url(){
    cd ./wp-content/themes/$site_slug/ || exit
    sed -i '' -e "s|APP_NAME=\"roboter\"|APP_NAME=\"$site_slug\"|g" .env
    sed -i '' -e "s|APP_URL=\"http://roboter.test\"|APP_URL=\"$url\"|g" .env
    cd -
}

function update_gitignore(){
    sed -i '' -e "s|roboter|$site_slug|g" ./.gitignore
}

function update_dir_names(){
    mv ./wp-content/themes/roboter ./wp-content/themes/$site_slug
    mv ./wp-content/plugins/roboter ./wp-content/plugins/$site_slug
}

function wp_setup(){
    wp core download --path=wp --skip-content --force --allow-root
    wp db create --path=wp
    wp core install --url="http://${PWD##*/}.test" --title="$site_name" --admin_name="$admin_name" --admin_password="$admin_password" --admin_email="test@test.com" --path=wp

    compile_assets

    wp theme activate $site_slug --path=wp
}

function wp_plugins_and_rewrite(){
    wp plugin activate --all --path=wp
    wp rewrite structure '/%postname%/'
}

# function clear_git_if_needed(){
#     if [[ -f ./.first_time ]]; then
#         rm -rf ./.git/
#         rm ./.first_time
#     fi
# }

# Execute
if [ ! -f ./.first_time ]; then
    echo "[HALTED] : Already installed. Skipping post install script."
    exit 0
fi

if [[ -z "$CI" ]] && [[ ! -f ./env.ini ]]; then
    echo -e "$ORANGE"
    echo "[HALTED] : env.ini not found -- did you forget to copy over env-example?"
    echo -e "$RESET"
    exit 1
fi

source env.ini

[[ -z nvm ]] && nvm use --lts

[[ -z "$dev_url" ]] && url="http://${PWD##*/}.test" || url=$dev_url

update_dir_names

if [[ -z "$CI" ]]; then
    wp_setup
    wp_plugins_and_rewrite
    compile_assets
fi

update_theme_info
update_gitignore
update_browsersync_url
# clear_git_if_needed
