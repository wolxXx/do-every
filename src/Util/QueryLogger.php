<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class QueryLogger implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    public static bool  $disabled = false;

    public static array $queries  = [];

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (false === str_contains($message, 'Executing statement') && false === str_contains($message, 'Executing query')) {
            return;
        }
        $exception = new \InvalidArgumentException();
        $paths     = [];
        foreach ($exception->getTrace() as $traceItem) {
            if (false === isset($traceItem['file'],)) {
                continue;
            }
            $blahFoo = \str_replace(\realpath(\ROOT_DIR) . \DIRECTORY_SEPARATOR, '', $traceItem['file']);
            if (false === \str_starts_with($blahFoo, 'vendor')) {
                $paths[] = trim($blahFoo . '::' . $traceItem['line']) . ' ' . $traceItem['function'] . '()';
                if (count($paths) > 5) {
                    break;
                }
            }
        }
        $context['paths'] = $paths;

        self::$queries[] = $context;
    }

    public function __destruct()
    {
        if (true === static::$disabled) {
            return;
        }
        \ob_start();
        $sqlFormatter = new \Doctrine\SqlFormatter\SqlFormatter(new \Doctrine\SqlFormatter\HtmlHighlighter([
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_QUOTE          => 'style="color: blue;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_BACKTICK_QUOTE => 'style="color: purple;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_RESERVED       => 'style="font-weight:bold; text-decoration: underline;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_BOUNDARY       => '',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_NUMBER         => 'style="color: green;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_WORD           => 'style="color: #333;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_ERROR          => 'style="background-color: red;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_COMMENT        => 'style="color: #aaa;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_VARIABLE       => 'style="color: orange;"',
                                                                                                               \Doctrine\SqlFormatter\HtmlHighlighter::HIGHLIGHT_PRE            => 'style="color: black; background-color: white;"',
                                                                                                           ],),);
        foreach (static::$queries as $query) {
            $rawQuery    = $query['sql'];
            $queryString = $sqlFormatter->format($rawQuery);
            $params      = [];
            if (\array_key_exists('params', $query)) {
                foreach ($query['params'] as $index => $param) {
                    $param    = $this->mapType($query['types'][$index]) . ' ' . \DoEveryApp\Util\View\DisplayValue::do($param);
                    $param    = '<span style="color: #f00;   font-style: oblique;">' . $param . '</span>';
                    $params[] = $param;
                }
            }
            foreach ($params as $param) {
                $pos = strpos($queryString, '?');
                if ($pos !== false) {
                    $queryString = substr_replace($queryString, $param, $pos, strlen('?'));
                }
            }
            echo \implode(' <- ', $query['paths']) . '<br>';
            echo $queryString;
        }
        $foo = \ob_get_clean();
        $end = microtime(true);
        echo '<div id="debug">';
        echo \number_format((($end - \STARTED) * 1000), 0) . 'ms execution time<br>';
        echo count(self::$queries) . ' queries executed.<br> <br>';
        echo $foo . '</div>';
    }

    private function mapType(\Doctrine\DBAL\ParameterType $type): string
    {
        return match ($type) {
            \Doctrine\DBAL\ParameterType::NULL         => '(NULL)',
            \Doctrine\DBAL\ParameterType::INTEGER      => '(integer)',
            \Doctrine\DBAL\ParameterType::STRING       => '(string)',
            \Doctrine\DBAL\ParameterType::LARGE_OBJECT => '(object)',
            \Doctrine\DBAL\ParameterType::BOOLEAN      => '(boolean)',
            \Doctrine\DBAL\ParameterType::BINARY       => '(binary)',
            \Doctrine\DBAL\ParameterType::ASCII        => '(ascii)',
        };
    }
}
