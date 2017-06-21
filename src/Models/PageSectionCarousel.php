<?php
/**
 * @author Jonathon Wallen
 * @date 9/6/17
 * @time 5:20 PM
 * @copyright 2008 - present, Monkii Digital Agency (http://monkii.com.au)
 */

namespace MonkiiBuilt\LaravelPageSectionsCarousel\Models;

use MonkiiBuilt\LaravelPages\Models\PageSection;

class PageSectionCarousel extends PageSection
{

    protected static $singleTableType = 'carousel';

    public function getDecorator()
    {
        $decoratorName = \MonkiiBuilt\LaravelPageSectionsCarousel\Decorator::class;
        return new $decoratorName($this);
    }

}