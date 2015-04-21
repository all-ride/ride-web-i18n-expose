<?php

namespace ride\web\rest\controller;

use ride\library\i18n\exception\LocaleNotFoundException;

use ride\service\LocaleExposeService;

use ride\web\mvc\controller\AbstractController;

/**
 * Controller for the REST calls of the exposed locales
 */
class LocaleExposeController extends AbstractController {

    /**
     * Action to get the exposed translation keys
     * @param \ride\service\LocaleExposeService $service
     * @param string $locale
     * @return null
     */
    public function indexAction(LocaleExposeService $service, $locale) {
        $this->setJsonView(array(
            'exposedTranslations' => $service->getExposedTranslationKeys($locale),
        ));
    }

    /**
     * Action to add exposed translation keys
     * @param \ride\service\LocaleExposeService $service
     * @param string $locale
     * @return null
     */
    public function addAction(LocaleExposeService $service, $locale) {
        $translationKeys = $this->request->getBodyParameter('translationKeys');
        if (!$translationKeys) {
            $this->response->setBadRequest();

            return null;
        }

        try {
            $service->addExposedTranslation($locale, $translationKeys);

            $this->setJsonView(array('exposedTranslations' => $service->getExposedTranslationKeys($locale)));
        } catch (LocaleNotFoundException $exception) {
            $this->response->setNotFound();
        }
    }

    /**
     * Action to remove exposed translation keys
     * @param \ride\service\LocaleExposeService $service
     * @param string $locale
     * @return null
     */
    public function removeAction(LocaleExposeService $service, $locale) {
        $translationKeys = $this->request->getBodyParameter('translationKeys');
        if (!$translationKeys) {
            $this->response->setBadRequest();

            return null;
        }

        try {
            $service->removeExposedTranslation($locale, $translationKeys);

            $this->setJsonView(array('exposedTranslations' => $service->getExposedTranslationKeys($locale)));
        } catch (LocaleNotFoundException $exception) {
            $this->response->setNotFound();
        }
    }

}
