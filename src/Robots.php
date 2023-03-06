<?php

namespace MadWeb\Robots;

class Robots
{
    /**
     * The lines of for the robots.txt.
     *
     * @var array
     */
    protected array $lines = [];

    /** @var callable|bool */
    protected static $shouldIndex = true;

    /**
     * Generate the robots.txt data.
     *
     * @return string
     */
    public function generate(): string
    {
        return implode(PHP_EOL, $this->lines);
    }

    /**
     * Add a Sitemap to the robots.txt.
     *
     * @param string $sitemap
     */
    public function addSitemap(string $sitemap): void
    {
        $this->addLine("Sitemap: $sitemap");
    }

    /**
     * Add a User-agent to the robots.txt.
     *
     * @param string $userAgent
     */
    public function addUserAgent(string $userAgent): void
    {
        $this->addLine("User-agent: $userAgent");
    }

    /**
     * Add a Host to the robots.txt.
     *
     * @param string $host
     */
    public function addHost(string $host): void
    {
        $this->addLine("Host: $host");
    }

    /**
     * Add a disallow rule to the robots.txt.
     *
     * @param string|array $directories
     */
    public function addDisallow(string|array $directories): void
    {
        $this->addRuleLine($directories, 'Disallow');
    }

    /**
     * Add a allow rule to the robots.txt.
     *
     * @param string|array $directories
     */
    public function addAllow(string|array $directories): void
    {
        $this->addRuleLine($directories, 'Allow');
    }

    /**
     * Add a rule to the robots.txt.
     *
     * @param string|array $directories
     * @param string       $rule
     */
    public function addRuleLine(string|array $directories, string $rule): void
    {
        foreach ((array) $directories as $directory) {
            $this->addLine("$rule: $directory");
        }
    }

    /**
     * Add a comment to the robots.txt.
     *
     * @param string $comment
     */
    public function addComment(string $comment): void
    {
        $this->addLine("# $comment");
    }

    /**
     * Add a spacer to the robots.txt.
     */
    public function addSpacer(): void
    {
        $this->addLine('');
    }

    /**
     * Add a line to the robots.txt.
     *
     * @param string $line
     */
    public function addLine(string $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Add multiple lines to the robots.txt.
     *
     * @param string|array $lines
     */
    protected function addLines(string|array $lines): void
    {
        foreach ((array) $lines as $line) {
            $this->addLine($line);
        }
    }

    /**
     * Reset the lines.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->lines = [];
    }

    /**
     * Set callback with should index condition.
     */
    public function setShouldIndexCallback(callable $callback): void
    {
        self::$shouldIndex = $callback;
    }

    /**
     * Check is application should be indexed.
     */
    public function shouldIndex(): bool
    {
        if (is_callable(self::$shouldIndex)) {
            return (bool) call_user_func(self::$shouldIndex);
        }

        return self::$shouldIndex;
    }

    /**
     * Render robots meta tag.
     */
    public function metaTag(): string
    {
        return '<meta name="robots" content="'.($this->shouldIndex() ? 'index, follow' : 'noindex, nofollow').'">';
    }
}
