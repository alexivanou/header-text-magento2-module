<?php

namespace BelVG\Tools\Console\Command;

use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;



class SetHeaderTextCommand extends Command
{

    const TEXT = 'text';

    protected $configWriter;

    protected $cacheTypeList;

    public function __construct(
        WriterInterface $configWriter,
        TypeListInterface $cacheTypeList
    )
    {
        $this->configWriter = $configWriter;
        $this->cacheTypeList = $cacheTypeList;

        parent::__construct();
    }

    protected function configure()
    {

        $options = [
            new InputArgument(
                self::TEXT,
                InputArgument::REQUIRED,
                'Custom Text'
            )
        ];

        $this->setName('belvg:set_header_text')
            ->setDescription('Setting the Header Text to be shown on every page.')
            ->setDefinition($options);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");

        if ($text = filter_var($input->getArgument(self::TEXT), FILTER_SANITIZE_SPECIAL_CHARS)) {

            $this->configWriter->save(
                'belvg/tools/custom_header_text',
                $text,
                $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId = 0
            );

            $this->cacheTypeList->cleanType(Config::TYPE_IDENTIFIER);

            $output->writeln("New header text '{$text}' set successfully.\n");

        } else {

            $this->configWriter->delete(
                'belvg/tools/custom_header_text',
                $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $scopeId = 0
            );

            $this->cacheTypeList->cleanType(Config::TYPE_IDENTIFIER);

            $output->writeln("Custom header text was deleted successfully.\n");

        }
        return $this;
    }
}
