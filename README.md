# Roboter Boilerplate
This is a WordPress project boilerplate that utilizes the [Sage](https://roots.io/sage/) starter theme. It comes preloaded with necessary plugins and automatically installs and configures WordPress for you.

### Requirements
* PHP 7.2+
* [Devilbox](https://gitlab.com/digital-strike/devilbox)
* [Composer](https://getcomposer.org/)
* [WP-CLI](https://wp-cli.org/)
* [Yarn](https://yarnpkg.com/lang/en/docs/install)

### Installation:
1. `git clone` the repo to the desired location.
2. Copy `env-example` to `env.ini` and configure `env.ini` as needed.
3. Run `composer install`
    * Please note that this step involves running `sed` against several files
    using values set in `config.ini` in step 2. If there were any errors in the 
    config file that went unnoticed until after this step you will need to checkout
    all files again to revert the changes and run `composer install` again.
