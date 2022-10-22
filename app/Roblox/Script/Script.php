<?php

namespace App\Roblox\Script;

use App\Signing\Signature;

class Script
{
    /**
     * The Lua data.
     *
     * @param string
     */
    private string $lua;

    /**
     * The signature.
     *
     * @param ?Signature
     */
    private ?Signature $signature = null;

    /**
     * Creates a new script.
     *
     * @param string $lua
     */
    public function __construct(string $lua)
    {
        $this->lua = $lua;
    }

    /**
     * Renders the script. Note that you may not "un-render" a script.
     *
     * @param array $parameters
     * @return Script
     */
    public function render(array $parameters) : Script
    {
        foreach ($parameters as $key => $value)
        {
            if (gettype($value) == 'object')
            {
                $value = $value->name;
            }

            $this->lua = str($this)->replace(('{{ ' . $key . ' }}'), (string) $value);
        }

        return $this;
    }

    /**
     * Signs the script. Note that you may not "un-sign" a script.
     *
     * @param bool $addComment
     * @return Script
     */
    public function sign($addComment = true): Script
    {
        $this->signature = signer('roblox')->sign($this);
        $this->prepend(str($this->signature)->wrap('%'));

        if ($addComment)
        {
            $this->prepend('--rbxsig');
        }

        return $this;
    }

    /**
     * Prepends value to the Lua script.
     *
     * @param string $code
     * @return Script
     */
    public function prepend(string $code): Script
    {
        $this->lua = $code . $this->lua;

        return $this;
    }

    /**
     * Appends value to the Lua script.
     *
     * @param string $code
     * @return Script
     */
    public function append(string $code): Script
    {
        $this->lua .= $code;

        return $this;
    }

    /**
     * Converts the script to its ASCII representation.
     *
     * @return array
     */
    public function toAscii(): array
    {
        return unpack('C*', $this);
    }

    /**
     * Converts the script to its loadstring form. This is irreversible.
     *
     * @return Script
     */
    public function loadstring(): Script
    {
        $this->lua = ('loadstring("\\' . implode('\\', $this->toAscii()) . '")()');

        return $this;
    }

    /**
     * If this is a loadstring script, this returns the raw Lua code. This is irreversible.
     *
     * @return Script
     * @throws \Exception
     */
    public function unpack(): Script
    {
        if (!str_contains($this, 'loadstring('))
        {
            throw new \Exception('Cannot unpack already unpacked script');
        }

        // startPosition gets the position of where "loadstring(" starts, adds length of "loadstring(" to get inside the function, and adds 1 to account for the quotation mark
        // endPosition removes all text before the startPosition position and then gets the next occurrence of a ")()" (signifying the end of the function) and removes one to account for the quotation mark and string, then adds startPosition for original length
        $startPosition = strpos($this, 'loadstring(') + strlen('loadstring(') + 1;

        if (strpos(substr($this, $startPosition), ')()') === false)
        {
            throw new \Exception('Malformed loadstring data');
        }

        $endPosition = $startPosition + (strpos(substr($this, $startPosition), ')()') - 1);
        $code = substr($this, $startPosition, $endPosition - $startPosition);

        // Parse the code
        $code = explode('\\', $code);
        $lua = '';

        array_shift($code); // Remove first empty element (since "\123\456", ['', '123', '456'])

        for ($i = 0; $i < count($code); $i++)
        {
            if (!is_numeric($code[$i]))
            {
                throw new \Exception('Malformed loadstring data');
            }

            $lua .= chr($code[$i]);
        }

        $this->lua = $lua;

        return $this;
    }

    /**
     * As a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->lua;
    }
}
