# Ride: Web Expose I18n 

Ride module to expose the i18n translator to javascript.

## How It Works?

When this module is installed, the translator.js will be added to your HTML views. 
This will make the Ride translator object available in Javascript. 
You can request translations from it through the _translate_ method.
Once all your translations are requested, you will have to submit the keys through the _submitTranslationKeys_.
Those keys will be included in the view from then on in the following requests. 

## Code Sample

You can translate a string in javascript with the following function:

```js
rideApp.translator.translate('button.save');
rideApp.translator.translate('success.data.saved', {data: "Sme"});
```

Once all translations are requested, you need to submit these keys to make them available in the following requests:

```js
rideApp.translator.submitTranslationKeys();
```

## Related Modules 

- [ride/app](https://github.com/all-ride/ride-app)
- [ride/app-i18n](https://github.com/all-ride/ride-app-i18n)
- [ride/lib-config](https://github.com/all-ride/ride-lib-config)
- [ride/lib-event](https://github.com/all-ride/ride-lib-event)
- [ride/lib-mvc](https://github.com/all-ride/ride-lib-mvc)
- [ride/lib-http](https://github.com/all-ride/ride-lib-http)
- [ride/lib-i18n](https://github.com/all-ride/ride-lib-i18n)
- [ride/web](https://github.com/all-ride/ride-web)
- [ride/web-i18n](https://github.com/all-ride/ride-web-i18n)

## Installation

You can use [Composer](http://getcomposer.org) to install this application.

```
composer require ride/web-i18n-expose
```
