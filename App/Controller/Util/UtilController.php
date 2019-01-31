<?php

declare(strict_types=1);

namespace App\Controller\Util;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\Request\Request;

class UtilController extends Controller
{
    protected $freeActions = [
        'translateJsAction',
        'getUrlJsAction',
    ];

    public function getUrlJsAction(Request $request) : void
    {
        $request->getSlim()
            ->response
            ->headers
            ->set('Content-Type', 'application/javascript');

        $routes = json_encode(urlAll());

        echo "function url(urlName) {
            var routes = {$routes};
            var shouldReturn = null;
            $.each(routes, function(index, route) {
                if (route.name == urlName) {
                    shouldReturn = route.url;
                }
            });
            
            return shouldReturn;
        }
        ";
    }

    public function translateJsAction(Request $request) : void
    {
        $request->getSlim()
            ->response
            ->headers
            ->set('Content-Type', 'application/javascript');

        $language = json_encode(translateAll());

        echo "function TranslateLanguage() {
            this.translate = function (key) {
                var languages = {$language};
                var shouldReturn = null;
                $.each(languages, function(index, language) {
                    if (index == key) {
                        shouldReturn = language;
                    }
                });
                
                return shouldReturn;
            }   
        }
        var language = new TranslateLanguage();
        ";
    }
}
