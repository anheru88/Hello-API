<?php

namespace App\Ship\Engine\Loaders;

use File;
use Illuminate\Support\Facades\View;

/**
 * Class ViewsLoaderTrait.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
trait ViewsLoaderTrait
{

    /**
     * loadViewsFromContainers
     */
    public function loadViewsFromContainers($containerName)
    {
        $containerViewDirectory = base_path('app/Containers/' . $containerName . '/UI/WEB/Views/');

        $this->loadViews($containerViewDirectory);
    }

    /**
     * @param void
     */
    public function loadViewsFromShip()
    {
//        $portViewsDirectory = base_path('app/Ship/') . $portFolderName . '/Views/';
//
//        $this->loadViews($portViewsDirectory);
    }

    /**
     * @param $directory
     */
    private function loadViews($directory)
    {
        if (File::isDirectory($directory)) {
            View::addLocation($directory);
        }
    }

}
