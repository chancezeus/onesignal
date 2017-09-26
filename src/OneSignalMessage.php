<?php

namespace NotificationChannels\OneSignal;

use Illuminate\Support\Arr;

class OneSignalMessage
{
    /** @var array */
    protected $body = [];

    /** @var array */
    protected $subject = [];

    /** @var string */
    protected $url;

    /** @var string */
    protected $icon;

    /** @var array */
    protected $data = [];

    /** @var array */
    protected $buttons = [];

    /** @var array */
    protected $webButtons = [];

    /** @var array */
    protected $extraParameters = [];

    /**
     * @param string $body
     *
     * @return static
     */
    public static function create($body = '')
    {
        return new static($body);
    }

    /**
     * @param string $body
     * @param string $subject
     */
    public function __construct($body = '', $subject = '')
    {
        $this->body($body)->subject($subject);
    }

    /**
     * Set the message body.
     *
     * @param string $value
     * @param string $locale
     *
     * @return $this
     */
    public function body($value, $locale = 'en')
    {
        $this->body[$locale] = $value;
        if ($locale != 'en' && empty($this->body['en'])) {
            $this->body['en'] = $value;
        }

        return $this;
    }

    /**
     * Set the message icon.
     *
     * @param string $value
     *
     * @return $this
     */
    public function icon($value)
    {
        $this->icon = $value;

        return $this;
    }

    /**
     * Set the message subject.
     *
     * @param string $value
     * @param string $locale
     *
     * @return $this
     */
    public function subject($value, $locale = 'en')
    {
        $this->subject[$locale] = $value;
        if ($locale != 'en' && empty($this->subject['en'])) {
            $this->subject['en'] = $value;
        }

        return $this;
    }

    /**
     * Set the message url.
     *
     * @param string $value
     *
     * @return $this
     */
    public function url($value)
    {
        $this->url = $value;

        return $this;
    }

    /**
     * Set additional data.
     *
     * @param string $key
     * @param string|array $value
     *
     * @return $this
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Set additional parameters.
     *
     * @param string $key
     * @param string|array $value
     *
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->extraParameters[$key] = $value;

        return $this;
    }

    /**
     * Add a web button to the message.
     *
     * @param OneSignalWebButton $button
     *
     * @return $this
     */
    public function webButton(OneSignalWebButton $button)
    {
        $this->webButtons[] = $button->toArray();

        return $this;
    }

    /**
     * Add a native button to the message.
     *
     * @param OneSignalButton $button
     *
     * @return $this
     */
    public function button(OneSignalButton $button)
    {
        $this->buttons[] = $button->toArray();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $message = [
            'contents' => $this->body,
            'headings' => $this->subject,
            'url' => $this->url,
            'buttons' => $this->buttons,
            'web_buttons' => $this->webButtons,
            'chrome_web_icon' => $this->icon,
            'chrome_icon' => $this->icon,
            'adm_small_icon' => $this->icon,
            'small_icon' => $this->icon,
        ];

        foreach ($this->extraParameters as $key => $value) {
            Arr::set($message, $key, $value);
        }

        foreach ($this->data as $data => $value) {
            Arr::set($message, 'data.'.$data, $value);
        }

        return $message;
    }
}
