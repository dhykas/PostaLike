<?php

if (!function_exists('redirectBack')) {
    /**
     * Redirect the user to the previous page.
     *
     * @param string|null $default
     * @param int $status
     * @param array $headers
     * @param bool $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    function redirectBack($default = null, $status = 302, $headers = [], $secure = null)
    {
        $previousUrl = url()->previous();

        // If the previous URL is the current URL, use the default URL
        if ($previousUrl === request()->url()) {
            return redirect($default, $status, $headers, $secure);
        }

        return redirect($previousUrl, $status, $headers, $secure);
    }
}
