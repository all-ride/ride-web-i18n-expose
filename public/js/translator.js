var rideApp = rideApp || {};

rideApp.translator = (function($, undefined) {
  var url = $('body').data('translation-url');
  var locale = $('html').attr('lang') || 'en';
  var translations = null;
  var translationKeys = [];

  var setTranslations = function(loadedTranslations) {
    translations = loadedTranslations;
  }

  var submitTranslationKeys = function() {
    if (url === undefined) {
      alert('Could not submit the translation: no data-translation-url set to the body tag');

      url = null;

      return;
    }

    if (url !== null && translationKeys.length !== 0) {
      $.post(url, { translationKeys: translationKeys });
    }
  };

  var translate = function(key, arguments) {
      if (translations === null || translations[key] === undefined) {
        translationKeys.push(key);

        return '[' + key + ']';
      }

      var translation = translations[key];

      if (arguments != undefined) {
          for (var i in arguments) {
            translation = translation.replace(new RegExp('%' + i + '%', 'g'), arguments[i]);
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
