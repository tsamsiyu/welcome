<?php namespace welcome\components\i18n;

    /* c o m m o n . p h r a s e s . e r r o r s . r e q u i r e d   =>   'Its field is required'   */
    /* |-----------|---------------|-------------|---------------|        |---------------------|   */
    /* |---------------------------------------------------------|                                  */
    /*                           LABEL                                                              */
    /* |-----------|                                                              PHRASE            */
    /*     CHUNK                                                                                    */
    /* |---------------------------|                                                                */
    /*            SEGMENT                                                                           */

interface ITranslator
{
    public function t($segment, $alias = null);
}