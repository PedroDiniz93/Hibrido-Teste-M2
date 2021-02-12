<?php
    namespace Hibrido\ColorPalette\Console\Command;

    use Hibrido\ColorPalette\Helper\Config;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    /**
     * Class SomeCommand
     */
    class ColorCommand extends Command
    {
        const COLOR = 'color';
        const STORE = 'store';

        /**
         * @var Hibrido\ColorPalette\Helper\Config
         */
        protected $helperConfig;

        /**
         * @param Config $scopeConfig
         */
        public function __construct(Config $helperConfig)
        {
            $this->helperConfig = $helperConfig;
            parent::__construct();
        }

        /**
         * @inheritDoc
         */
        protected function configure()
        {
            $this->setName('color-change');
            $this->setDescription('Change button color');
            $this->addOption(
                self::COLOR,
                null,
                InputOption::VALUE_REQUIRED,
                'Color'
            );

            $this->addOption(
                self::STORE,
                null,
                InputOption::VALUE_REQUIRED,
                'Store id'
            );

            parent::configure();
        }

        /**
         * Execute the command
         *
         * @param InputInterface $input
         * @param OutputInterface $output
         *
         * @return null|int
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $color = $input->getOption(self::COLOR);
            $storeId = $input->getOption(self::STORE);

            if(!preg_match('/^[a-zA-Z0-9]{6}/', $color)) {
               return $output->writeln('Por favor insira a HEX da cor corretamente.');
            }

            if(!$storeId) {
                return $output->writeln('Por favor insira o store ID.');
             }

            $this->helperConfig->setConfigValue('color', $color, $storeId);
            $output->writeln('Cor do botão -> ' . $this->helperConfig->getConfigValue('color' , 1));
        }
    }