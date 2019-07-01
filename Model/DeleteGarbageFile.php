<?php
/**
 * Created by PhpStorm.
 * User: uho0613
 * Date: 30.06.19
 * Time: 23:41
 */

namespace TestModules\CleanerImage\Model;

use TestModules\CleanerImage\Api\WorkDirectoryInterface;

use Magento\Catalog\Model\ResourceModel\Product\ImageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;


class DeleteGarbageFile implements WorkDirectoryInterface
{
    protected $imageFactory;
    protected $directoryList;
    protected $output;
    public function __construct(ImageFactory $imageFactory,DirectoryList $directoryList)
    {
        $this->directoryList = $directoryList;
        $this->imageFactory = $imageFactory;
    }

    public function workingWithDirectory()
    {
        $path = $this->directoryList->getPath(DirectoryList::MEDIA);
        $path = $path . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'product';
        $result = $this->recursiveDiretory($path);
        return $result;
    }

    public function recursiveDiretory($path)
    {
        $files = array();
        $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS;

        $directoryIterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, $flags)
        );

        $imageListIterator = new\RegexIterator($directoryIterator, "/\.jpg|\.jpeg|\.png|\.gif/");
        $imageGenerator = $this->imageFactory->create();

$count = 0;


            foreach ($imageListIterator as $image) {
                if (strstr($image->getRealPath(), '/cache/')) {
                    continue;
                }
                $pathsDir = $image->getRealPath();
                $myFlag = true;
                $allImages = $imageGenerator->getAllProductImages();

                foreach ($allImages as $imageGen) {
                    $pathBd = $imageGen['filepath'];
                    if (strpos($pathsDir, $pathBd)) {
                       $myFlag = false;
                    }
            }
                if($myFlag){
                    $files[] = $pathsDir;
                    unlink($pathsDir);
                    $count++;
                }
        }

      $files[] = $count;
      return $files;
    }

}