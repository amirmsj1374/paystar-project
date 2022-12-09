# paystar-test

`Its a test project which created for connection to paystar gateway`.

## Installation

1. Make sure you install npm and run:

```
npm run build
```

or 

```
npm run dev
```

2. Add some key for contains ngrok url, paystar_gateway_id and paystar_encryption_key in .env file as follow:

```
PAYSTAR_GATEWAY_ID="Your Gateway Id"
PAYSTAR_ENCRYPTION_KEY="Your Encryption Key"
APP_DMAIN="Ngrok callback url"
```
Ngrok callback url is just for local project on your system if you don`t wanna use it:

```
WEBHOOK_CALLBACK="https://webhook.site/address"
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
