<?php

namespace ride\service;

use ride\library\config\Config;
use ride\library\event\Event;
use ride\library\i18n\I18n;
use ride\library\mvc\view\HtmlView;

/**
 * Service to handle exposed locales
 */
class LocaleExposeService {

    /**
     * Name of the exposed translations parameter
     * @var string
     */
    const PARAM_EXPOSED_LOCALE = 'i18n.expose.';

    /**
     * Instance of the I18n
     * @var \ride\library\i18n\I18n
     */
    protected $i18n;

    /**
     * Instance of the configuration
     * @var \ride\library\config\Config
     */
    protected $config;

    /**
     * Constructs a new service
     * @param \ride\library\i18n\I18n $i18n Instance of the I18n
     * @param \ride\library\config\Config $config Instance of the config
     * @return null
     */
    public function __construct(I18n $i18n, Config $config) {
        $this->i18n = $i18n;
        $this->config = $config;
    }

    /**
     * Adds an exposed translation to the list
     * @param string $locale Code of the locale
     * @param string|array $translationKey Translation key to add
     * @return null
     */
    public function addExposedTranslation($locale, $translationKeys) {
        if (!is_array($translationKeys)) {
            $translationKeys = array($translationKeys);
        }

        $exposedTranslations = array_flip($this->getExposedTranslationKeys($locale));
        foreach ($translationKeys as $translationKey) {
            if (isset($exposedTranslations[$translationKey])) {
                continue;
            }

            $exposedTranslations[$translationKey] = true;
        }

        $this->setExposedTranslationKeys($locale, array_keys($exposedTranslations));
    }

    /**
     * Removes an exposed translation from the list
     * @param string $locale Code of the locale
     * @param string $translationKey Translation key to remove
     * @return boolean True if the translation key was removed, false if it
     * doesn't exist
     */
    public function removeExposedTranslation($locale, $translationKey) {
        if (!is_array($translationKeys)) {
            $translationKeys = array($translationKeys);
        }

        $exposedTranslations = array_flip($this->getExposedTranslationKeys($locale));
        foreach ($translationKeys as $translationKey) {
            if (!isset($exposedTranslations[$translationKey])) {
                continue;
            }

            unset($exposedTranslations[$translationKey]);
        }

        $this->setExposedTranslationKeys($locale, array_keys($exposedTranslations));
    }

    /**
     * Sets the exposed translations
     * @param string $locale Code of the locale
     * @param array $exposedTranslations Array with translation keys
     * @return null
     */
    protected function setExposedTranslationKeys($locale, array $exposedTranslations) {
        $this->config->set(self::PARAM_EXPOSED_LOCALE . $locale, $exposedTranslations);
    }

    /**
     * Gets the exposed translation keys
     * @param string $locale Code of the locale
     * @return array Array with translation keys
     */
    public function getExposedTranslationKeys($locale) {
        return $this->config->get(self::PARAM_EXPOSED_LOCALE . $locale, array());
    }

    /**
     * Gets the exposed translations
     * @param string $locale Code of the locale
     * @return array Array with translation key as key and the unprocessed translation as value
     */
    public function getExposedTranslations($locale) {
        $result = array();

        $translator = $this->i18n->getTranslator($locale);

        $exposedTranslationKeys = $this->getExposedTranslationKeys($locale);
        foreach ($exposedTranslationKeys as $translationKey) {
            $result[$translationKey] = $translator->getTranslation($translationKey);
        }

        return $result;
    }

    /**
     * Prepares the template view with the application variable
     * @param \ride\library\event\Event $event
     * @param \ride\library\dependency\DependencyInjector $dependencyInjector
     * @return null
     */
    public function prepareHtmlView(Event $event) {
        $web = $event->getArgument('web');
        $response = $web->getResponse();
        if (!$response) {
            return;
        }

        $view = $response->getView();
        if (!$view instanceof HtmlView) {
            return;
        }

        $locale = $this->i18n->getLocale()->getCode();

        $view->addJavascript($web->getRequest()->getBaseUrl() . '/js/translator.js', true);
        $view->addInlineJavascript('rideApp.translator.setTranslations(' . json_encode($this->getExposedTranslations($locale)) . ');');
        $view->addInlineJavascript('rideApp.translator.submitTranslationKeys();');
    }

}
