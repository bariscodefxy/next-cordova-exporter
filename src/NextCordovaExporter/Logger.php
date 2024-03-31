<?php

namespace NextCordovaExporter;

use Psr\Log\LoggerInterface;

final class Logger implements LoggerInterface
{

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function emergency(\Stringable|string $message, array $context = []): void
    {
        echo "[ALERT] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function alert(\Stringable|string $message, array $context = []): void
    {
        echo "[ALERT] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function critical(\Stringable|string $message, array $context = []): void
    {
        echo "[CRITICAL] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function error(\Stringable|string $message, array $context = []): void
    {
        echo "[ERROR] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function warning(\Stringable|string $message, array $context = []): void
    {
        echo "[WARNING] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function notice(\Stringable|string $message, array $context = []): void
    {
        echo "[NOTICE] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function info(\Stringable|string $message, array $context = []): void
    {
        echo "[INFO] $message\n";
    }

    /**
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function debug(\Stringable|string $message, array $context = []): void
    {
        echo "[DEBUG] $message\n";
    }

    /**
     * @param $level
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    #[\Override] public function log($level, \Stringable|string $message, array $context = []): void
    {
        echo "[LOG] $message\n";
    }
}