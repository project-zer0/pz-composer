<?php

declare(strict_types=1);

namespace ProjectZer0\PzComposer;

use LogicException;
use ProjectZer0\Pz\Config\PzModuleConfigurationInterface;
use ProjectZer0\Pz\Console\Command\ProcessCommand;
use ProjectZer0\Pz\Module\PzModule;
use ProjectZer0\Pz\Process\DockerProcess;
use ProjectZer0\Pz\Process\ProcessInterface;
use ProjectZer0\Pz\ProjectZer0Toolkit;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Aurimas Niekis <aurimas@niekis.lt>
 */
class PzComposerModule extends PzModule
{
    private ?string $cwd = null;

    public function getCommands(): array
    {
        return [
            new class($this->getCWD()) extends ProcessCommand {
                protected static $defaultName = 'composer';

                public function __construct(private string $cwd)
                {
                    parent::__construct();
                }

                protected function configure(): void
                {
                    $this->setDescription('Dependency Management for PHP');
                }

                public function getProcess(
                    array $processArgs,
                    InputInterface $input,
                    OutputInterface $output
                ): ProcessInterface {
                    $imageName = $this->getConfiguration()['composer']['image'] ?? 'composer';

                    return (new DockerProcess(
                        $imageName,
                        $processArgs,
                        interactive: true,
                        workDir: '/project',
                        exec: true
                    ))->addVolume($this->cwd, '/project');
                }
            },
        ];
    }

    public function boot(ProjectZer0Toolkit $toolkit): void
    {
        $this->cwd = $toolkit->getCurrentDirectory();
    }

    /**
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function getConfiguration(): ?PzModuleConfigurationInterface
    {
        return new class() implements PzModuleConfigurationInterface {
            public function getConfigurationNode(): NodeDefinition
            {
                $treeBuilder = new TreeBuilder('composer');

                return $treeBuilder->getRootNode()
                    ->children()
                        ->scalarNode('image')
                            ->defaultValue('composer')
                        ->end()
                    ->end();
            }
        };
    }

    public function getName(): string
    {
        return 'composer';
    }

    private function getCWD(): string
    {
        if (null === $this->cwd) {
            throw new LogicException('PzModule was not initialized correctly');
        }

        return $this->cwd;
    }
}
