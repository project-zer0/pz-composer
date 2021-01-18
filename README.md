# Project Zer0 Composer Module

A pz module for PHP Composer - Dependency Management for PHP.

## Install

Via composer:

```shell
$ composer require --dev project-zer0/pz-composer
```

## Configuration

This module provides following config block to `.pz.yaml` file

```yaml
project-zer0:
  composer:
    image: composer # Docker image name to use for composer command
```


## Commands

This module provides these commands in `pz` tool

```shell
$ pz composer
```

```
   ______
  / ____/___  ____ ___  ____  ____  ________  _____
 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
\____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
                    /_/
Composer version 2.0.8 2020-12-03 17:20:38

Usage:
  command [options] [arguments]

Options:
  -h, --help                     Display this help message
  -q, --quiet                    Do not output any message
  -V, --version                  Display this application version
      --ansi                     Force ANSI output
      --no-ansi                  Disable ANSI output
  -n, --no-interaction           Do not ask any interactive question
      --profile                  Display timing and memory usage information
      --no-plugins               Whether to disable plugins.
  -d, --working-dir=WORKING-DIR  If specified, use the given directory as working directory.
      --no-cache                 Prevent use of the cache
  -v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  about                    Shows the short information about Composer.
  ...
```

## Testing

Run test cases

```bash
$ composer test
```

Run test cases with coverage (HTML format)

```bash
$ composer test-coverage
```

Run PHP style checker

```bash
$ composer cs-check
```

Run PHP style fixer

```bash
$ composer cs-fix
```

Run all continuous integration tests

```bash
$ composer ci-run
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
