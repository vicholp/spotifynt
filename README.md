# Laravel template

## Stack

- PHP 8.1
- ECMAScript 6
- Node 16
- Laravel 9
- Vue 3
- Tailwind

## Packages

### SEO

 - spatie/laravel-robots-middleware
 - spatie/laravel-sitemap
 - spatie/schema-org
 - @gtm-support/vue-gtm

### Sentry



## Linters

### PHP

- phpstan with larastan (already installed)
  - [x] [vscode](https://marketplace.visualstudio.com/items?itemName=swordev.phpstan)
  - [ ] action

- php-cs-fixer (already installed)
  - [x] [vscode](https://marketplace.visualstudio.com/items?itemName=junstyle.php-cs-fixer)
  - [ ] action

### JS

- eslint
  - [x] vscode
  - [ ] action

- stylelint
  - [ ] vscode
  - [ ] action

### Extra


## Testing

### PHP with Pest

    php artisan test

- [ ] code coverage
- [ ] action

### Browser with Laravel Dusk

    php artisan pest:dusk

- [ ] action

### JS with Jest

TODO

- [ ] code coverage
- [ ]  action

## Github Actions

### integration workflow

- [ ] Build PHP
- [ ] Build Node
- [ ] composer cache
- [ ] composer isntall
- [ ] node cache
- [ ] node install
- [ ] run linters
- [ ] run testing
