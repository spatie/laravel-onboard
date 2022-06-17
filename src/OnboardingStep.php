<?php

namespace Spatie\Onboard;

use Illuminate\Support\Arr;

/**
 * The main class for this package. This contains all the logic
 * for creating, and accessing onboarding steps.
 */
class OnboardingStep
{
    /**
     * The container for all defined attributes of this step.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The condition on which to determine if the step is complete
     * or not. The user class gets passed through to this.
     *
     * @var callable|null
     */
    protected $completeIf;

    /**
     * The current user model.
     *
     * @var object|null
     */
    protected $user;

    /**
     * Create a new onboarding step.
     *
     * @param string $title
     */
    public function __construct($title)
    {
        $this->attributes(['title' => $title]);
    }

    /**
     * Add "CTA" (Call To Action) verbaige. Best used on a button or link.
     *
     * @param  string $cta
     * @return $this
     */
    public function cta($cta)
    {
        $this->attributes(['cta' => $cta]);

        return $this;
    }

    /**
     * Set a link to be used as the url to a CTA (button / link).
     *
     * @param  string $link
     * @return $this
     */
    public function link($link)
    {
        $this->attributes(['link' => $link]);

        return $this;
    }

    /**
     * A closure containing the condition for determining if the
     * step is complete or not.
     *
     * @param  callable $callback
     * @return $this
     */
    public function completeIf(callable $callback)
    {
        $this->completeIf = $callback;

        return $this;
    }

    /**
     * Set the user to be passed through to the supplied callback.
     *
     * @param object $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Determine if the the step is complete or not.
     *
     * @return bool
     */
    public function complete()
    {
        if ($this->completeIf && $this->user) {
            return ! ! call_user_func_array($this->completeIf, [$this->user]);
        }

        return false;
    }

    /**
     * Determine if the step has not yet been completed.
     *
     * @return bool
     */
    public function incomplete()
    {
        return ! $this->complete();
    }

    /**
     * Get a given attribute from the step.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function attribute($key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * Specify the step's attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function attributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * Dynamically access the step's attributes.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attribute($key);
    }
}
