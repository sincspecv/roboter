#!/usr/bin/env bash

RED='\033[0;31m'
ORANGE='\033[0;33m'
RESET='\033[0m' # No Color

url="http://${PWD##*/}.loc"

# NPM Install and compile assets
function compile_assets(){
    cd ./wp-content/themes/$site_slug/ || exit
    composer install
    yarn && yarn build
    cd -
}

function update_theme_info() {
  cd ./wp-content/themes/$site_slug/resources || exit
  sed -i '' -e "s|Theme Name:         Roboter|Theme Name:         $site_name|g" style.css
  cd -
}

function update_browsersync_url(){
    cd ./wp-content/themes/$site_slug/resources/assets || exit
    sed -i '' -e "s|\"publicPath\": \"/wp-content/themes/roboter\"|\"publicPath\": \"/wp-content/themes/$site_slug\"|g" config.json
    sed -i '' -e "s|\"devUrl\": \"http://roboter.loc\"|\"devUrl\": \"$url\"|g" config.json
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
    wp core install --url="http://${PWD##*/}.loc" --title="$site_name" --admin_name="$admin_name" --admin_password="$admin_password" --admin_email="test@test.com" --path=wp
    wp theme activate $site_slug/resources --path=wp
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
    echo "[HALTED] : .env not found -- did you forget to copy over env-example?"
    echo -e "$RESET"
    exit 1
fi

source env.ini
update_dir_names
if [[ -z "$CI" ]]; then
    wp_setup
    compile_assets
fi
update_theme_info
update_gitignore
update_browsersync_url
# clear_git_if_needed
