<?php

declare(strict_types=1);

namespace App\Controller\File;

use Infrastructure\Controller\AbstractController as Controller;
use Infrastructure\File\Service\FileService;
use Infrastructure\File\ValueObject\File;
use Infrastructure\Request\Request;
use Infrastructure\Response\Response;

class FileController extends Controller
{
    public function uploadAction(Request $request) : Response
    {
        $typesAccept = explode(";", $request->getParam('typesAccept'));
        $dir         = $request->getParam('dir', '');
        $maxsize     = $request->getParam('maxsize', 2000000);
        $response    = [];

        foreach ($request->getFiles() as $key => $file) {
            $valueObject = new File($file, $dir, (int)$maxsize);

            if ($valueObject->getSize() > $valueObject->getMaxsize()) {
                $response[] = [
                    'success' => false,
                    'link'    => '',
                    'message' => translate('ERROR_MAXSIZE_FILE', ['{{maxSizeFormat}}' => $valueObject->getMaxSizeFormat()])
                ];
                continue;
            }

            $extension = pathinfo($valueObject->getName(), PATHINFO_EXTENSION);
            $extension = '.' . strtolower($extension);

            if (count($typesAccept) > 0 && !in_array($extension, $typesAccept)) {
                $response[] = [
                    'success' => false,
                    'link'    => '',
                    'message' => translate('ERROR_TYPES_ACCEPT_FILE', ['{{extension}}' => $extension])
                ];
                continue;
            }

            $send = $this->getFileService()->push($valueObject);

            if (empty($send)) {
                $response[] = [
                    'success' => false,
                    'link'    => '',
                    'message' => translate('ERROR_FILENAME_FILE', ['{{fileName}}' => $valueObject->getName()])
                ];
                continue;
            }

            $response[] = [
                'success' => true,
                'link'    => $send,
                'message' => translate('FILE_MESSAGE_SENT_WITH_SUCCESS', ['{{fileName}}' => $valueObject->getName()])
            ];
        }

        return $this->json($response);
    }

    private function getFileService() : FileService
    {
        return $this->getService('file');
    }
}
