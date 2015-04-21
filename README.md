# Ride: Expose I18n 

Ride module to expose the i18n translator to javascript.

## How It Works?

When this module is installed, the translator.js will be added to your HTML views. 
This will make the Ride translator object available in Javascript. 
You can request translations from it through the __translate__ method.
Once all your translations are requested, you will have to submit the keys through the __submitTranslationKeys__.
Those keys will be included in the view from then on in the following requests. 

## Setup

You can translate a string in javascript with the following function:

    rideApp.translator.translate('button.save');
    rideApp.translator.translate('success.data.saved', {data: "Sme"});
    
Once all translations are requested, you need to submit these keys to make them available in the following requests:

    rideApp.translator.submitTranslationKeys();
    
