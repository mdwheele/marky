# marky

Marky is a markov-chain based text generator... it will be a continuance of the work at http://www.haykranen.nl/2008/09/21/markov.

## Install

Via Composer

``` bash
$ composer require mdwheele/marky
```

## Usage

**From Raw Text**:

``` php
require_once('vendor/autoload.php');

use Marky\Marky;

// Strips new-lines, but that's it...
$marky = Marky::fromString('something long here is better');

echo $marky->generate(500);
```

**From a File**:

``` php
require_once('vendor/autoload.php');

use Marky\Marky;

$marky = Marky::fromFile('source.txt');

echo $marky->generate(500);
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mdwheele@ncsu.edu instead of using the issue tracker.

## Credits

- [Dustin Wheeler](https://github.com/mdwheele)
- [Hay Kranen](http://www.haykranen.nl/2008/09/21/markov)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
