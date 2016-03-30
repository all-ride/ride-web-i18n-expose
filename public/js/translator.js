
var rideApp = rideApp || {};

rideApp.translator = (function($, undefined) {
  var url = $('body').data('translation-url');
  var locale = $('html').attr('lang') || 'en';
  var translations = null;
  var translationKeys = [];

  var setTranslations = function(loadedTranslations) {
    translations = loadedTranslations;
  };

  var submitTranslationKeys = function() {
    if (url === undefined) {
      alert('Could not submit the translation: no data-translation-url set to the body tag');

      url = null;

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
      $.post(url, { translationKeys: newTranslationKeys });
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

  return {
    setTranslations: setTranslations,
    submitTranslationKeys: submitTranslationKeys,
    translate: translate
  };

})(jQuery);
