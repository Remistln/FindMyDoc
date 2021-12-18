<?php

namespace App\Services;

use App\Entity\File;


class TableFile
{
    public function GetFiles()
    {
        $appel = file_get_contents("http://localhost:8000/api/fichiers");
        $appel = json_decode($appel, true);
        $tableau = [];
        $files = $appel["hydra:member"];
        foreach($files as $fileTableau)
        {
            $service = (new File())
                ->setId($fileTableau['id'])
                ->setName($fileTableau['name'])
            ;
            array_push($tableau, $service);
        }

        return $tableau;
    }

    public function FileByOwner($owner)
    {
        $files = $this->GetFiles();

        $fileTrouve = [];

        foreach($files as $file)
        {
            if ($file->getOwner() == $owner)
            {
                array_push($fileTrouve,$file);
            }
        }

        return $fileTrouve;
    }

    public function PageByName($name)
    {
        $files = $this->GetFiles();

        $fileTrouve = [];

        foreach($files as $file)
        {
            if ($file->getName() == $name)
            {
                array_push($fileTrouve,$file);
            }
        }

        return $fileTrouve;
    }
}