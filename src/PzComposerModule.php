<?php

declare(strict_types=1);

namespace ProjectZer0\PzComposer;

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
    public function getCommands(): array
    {
        return [
            new class() extends ProcessCommand {
                protected static $defaultName = 'php:composer';

                protected function configure(): void
                {
                    $this->setDescription('Dependency Management for PHP')
                        ->setAliases(['composer']);
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
                        cleanUp: true,
                        workDir: '/project',
                        exec: true
                    ))->addVolume('$PZ_PWD', '/project');
                }
            },
        ];
    }

    public function boot(ProjectZer0Toolkit $toolkit): void
    {
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
}
