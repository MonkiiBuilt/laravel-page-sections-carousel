<?php
/**
 * @author Jonathon Wallen
 * @date 9/6/17
 * @time 5:19 PM
 * @copyright 2008 - present, Monkii Digital Agency (http://monkii.com.au)
 */

namespace MonkiiBuilt\LaravelPageSectionsCarousel;

use MonkiiBuilt\LaravelPages\PageSectionDecoratorAbstract as PageSectionDecoratorAbstract;

class Decorator extends PageSectionDecoratorAbstract
{
    public function renderForm() {
        return view('page-sections-carousel::carousel', ['section' => $this->wrapped]);
    }

}