<?php
/**
 * @author Jonathon Wallen
 * @date 9/6/17
 * @time 5:05 PM
 * @copyright 2008 - present, Monkii Digital Agency (http://monkii.com.au)
 */

namespace MonkiiBuilt\LaravelPageSectionsCarousel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MonkiiBuilt\LaravelPages\Models\PageSection;
use MonkiiBuilt\LaravelPageSectionsCarousel\Models\PageSectionCarousel;

class ServiceProvider extends BaseServiceProvider
{
    protected $defer = false;

    public function boot(\MonkiiBuilt\LaravelAdministrator\PackageRegistry $packageRegistry)
    {
        $packageRegistry->registerPackage('MonkiiBuilt\LaravelPageSectionsCarousel');

        PageSection::addSingleTableSubclass(PageSectionCarousel::class);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'page-sections-carousel');

    }
}