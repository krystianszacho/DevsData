# PHP Commission Calculator

This project is a commission calculator written in PHP. It takes in transaction data and calculates the commission based on the country of origin (EU or non-EU) and the currency.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- Docker
- Docksal

### Installation

1. Clone the repository to your local machine.

    SSH: `git@github.com:krystianszacho/DevsData.git`

    HTTPS: 'https://github.com/krystianszacho/DevsData.git'
2. Navigate to the project directory.
3. Run `fin init` to initialize the Docksal environment.

### Usage

Navigate to the application directory:

`cd var/www`

Run the application with the following command:

`fin exec php app.php input.txt`

The `input.txt` file should contain the transaction data in JSON format, e.g.:

[
{"bin":"45717360","amount":"100.00","currency":"EUR"},
{"bin":"516793","amount":"50.00","currency":"USD"},
{"bin":"45417360","amount":"10000.00","currency":"JPY"},
{"bin":"41417360","amount":"130.00","currency":"USD"},
{"bin":"4745030","amount":"2000.00","currency":"GBP"}
]
\`\`\`

The output will be a list of calculated commissions for each transaction.

## Application Structure

The main components of the application are:

- `app.php`: The entry point of the application. It initializes the necessary services and calculates the commission for each transaction.
- `CommissionCalculator.php`: This class handles the commission calculation logic.
- `BinProvider.php`: This service fetches BIN data from an external API.
- `CurrencyRateProvider.php`: This service fetches currency rate data from an external API.

## Author

- **Krystian Szachogłuchowicz** - [krystian.site](https://krystian.site/)