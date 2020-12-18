<?php

namespace Rabcreatives\Oppwa\Components\Credential\Transformations;

use Rabcreatives\Oppwa\Components\Credential\Credential;
use Illuminate\Support\Facades\Storage;

trait CredentialTransformable
{
    /**
     * Transform the credential
     *
     * @param Credential $credential
     * @return Credential
     */
    protected function credentialSimpleTransform(Credential $credential)
    {
        $cred = new Credential;
        $cred->id = (int) $credential->credentialid;
        $cred->configurationid = $credential->configurationid;

        return $cred;
    }


    protected function credentialTransform(Credential $credential)
    {
        $cred = new Credential;
        $cred->id = (int) $credential->credentialid;
        $cred->configurationid = $credential->configurationid;
        $set = explode(',', $credential->set);
        $entity = explode(':', $set[0]);
        $bearer = explode(':', $set[1]);

        $cred->entity = $entity[1];
        $cred->bearer = $bearer[1];

        return $cred;
    }
}
