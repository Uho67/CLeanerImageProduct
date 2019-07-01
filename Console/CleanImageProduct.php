<?php
/**
 * Created by PhpStorm.
 * User: uho0613
 * Date: 30.06.19
 * Time: 19:35
 */

namespace TestModules\CleanerImage\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Magento\Catalog\Model\ResourceModel\Product\ImageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

use TestModules\CleanerImage\Model\DeleteGarbageFile;
class CleanImageProduct extends Command
{

    protected $directoryList;
    protected $imageFactory;
    protected $deleteGarbageFile;

    public function __construct(DirectoryList $directoryList,DeleteGarbageFile $deleteGarbageFile,
                                ImageFactory $imageFactory,$name = null)
    {
        $this->deleteGarbageFile = $deleteGarbageFile;
        $this->directoryList = $directoryList;
        $this->imageFactory = $imageFactory;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('testmodules:cleanerimage:cleaner');
        $this->setDescription('CLean image product which use nobody.');
    }


    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln("<error>My COMMAND</error>");
        $result = $this->deleteGarbageFile->workingWithDirectory();
        foreach ($result as $path){
            $output->writeln("<error>$path</error>");
        }
    }


}