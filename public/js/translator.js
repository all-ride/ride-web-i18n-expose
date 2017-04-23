var rideApp = rideApp || {};

rideApp.translator = (function(undefined) {
  var url = document.body.dataset.translationUrl;
  var locale = document.documentElement.lang || 'en';
  var translations = null;
  var translationKeys = [];

  var setTranslations = function(loadedTranslations) {
    translations = loadedTranslations;
  };

  var submitTranslationKeys = function() {
    if (url === undefined) {
      console.warn('Could not submit the translation: no data-translation-url set to the body tag');
      return;
    }

    var newTranslationKeys = [];
    for (var i = 0, len = translationKeys.length; i < len; i++) {
      var key = translationKeys[i];
      if (translations[key] === undefined) {
        newTranslationKeys.push(key);
      }
    }

    if (url !== null && newTranslationKeys.length !== 0) {
      var request = new XMLHttpRequest();
      request.open('POST', url, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send(prepareDataString({ translationKeys: newTranslationKeys }));
    }
  };

  var translate = function(key, args) {
      if (translations === null || translations[key] === undefined || translations[key] === null) {
        translationKeys.push(key);

        return '[' + key + ']';
      }

      var translation = translations[key];

      if (args !== undefined) {
          for (var i in args) {
            translation = translation.replace(new RegExp('%' + i + '%', 'g'), args[i]);
          }
      }

      return translation;
  };

  function prepareDataString(data) {
    var urlEncodedDataPairs = [];
    for(name in data) {
      urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
    }

    // Combine the pairs into a single string and replace all %-encoded spaces to
    // the '+' character; matches the behaviour of browser form submissions.
    return urlEncodedDataPairs.join('&').replace(/%20/g, '+');
  }

  return {
    setTranslations: setTranslations,
    submitTranslationKeys: submitTranslationKeys,
    translate: translate
  };
})();
