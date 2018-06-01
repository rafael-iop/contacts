<?php

if (! function_exists('gravatar_or_fallback')) {
    
    /**
     * Generate a "Gravatar" avatar url based in $email.
     * If $email isn't found in Gravatar: use "UI Avatars" service as fallback.
     *
     * Gravatar docs: http://pt.gravatar.com/site/implement/images/
     * UI Avatars docs: https://ui-avatars.com/
     * 
     * @param  string $email 		 User email to find in Gravatar.
     * @param  string $fallbackName  User full name to find in UI Avatars.
     * @return string
     */
    function gravatar_or_fallback(string $email, string $fallbackName): string
    {
        $gravatarHashedEmail = md5($email);

        $fallbackServiceUrl = urlencode('https://ui-avatars.com/api/' . $fallbackName);

        return "https://www.gravatar.com/avatar/{$gravatarHashedEmail}?default={$fallbackServiceUrl}";
    }
}