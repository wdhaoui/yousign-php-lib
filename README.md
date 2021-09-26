# Yousign

## Bridge: Symfony

### Installation

Add this custom repository in your composer.json.
```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:wdhaoui/yousign-php-lib.git"
    }
]
```

Declare the bundle.
```
Wdhaoui\Yousign\Bridge\Symfony\WdhaouiYousignBundle::class => ['all' => true],
```

### Config

The config is mandatory
```
wdhaoui_yousign:
    base_uri: yousign_base_uri
    access_token: yousign_access_token
```

### Usage

use the `Wdhaoui\Yousign\Signature` service in your code and that's it, you can create or get a procedure.


```
<?php

namespace App\Controller;

use Wdhaoui\Yousign\Model\File;
use Wdhaoui\Yousign\Model\FileObject;
use Wdhaoui\Yousign\Model\Member;
use Wdhaoui\Yousign\Model\Procedure;
use Wdhaoui\Yousign\Signature;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TestController extends Controller
{
    /**
     * @Route("/create", name="create")
     */
    public function create(Signature $signature, SerializerInterface $serializer)
    {
        // create signature
        $firstMember = new Member();
        $fileObject = new FileObject();
        $fileObject->setPosition('76,152,236,192');
        $firstMember
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setEmail('john.doe@email.com')
            ->setPhone('0610101010')
            ->setPosition(1)
            ->addFileObject($fileObject);

        $secondMember = new Member();
        $secondMember
            ->setFirstname('John 2')
            ->setLastname('Doe 2 ')
            ->setEmail('john.doe2@email.com')
            ->setPhone('0610101010')
            ->setPosition(2)
            ->addFileObject((clone $fileObject)->setPosition('397,156,557,196'));

       
        $file = new File();
        $file->setName('receipt.pdf')
            ->setContent(\file_get_contents('path\path'))
            ->setType(File::SIGNABLE_TYPE);

        $procedure = new Procedure();
        $procedure
            ->setName('name')
            ->setDescription('description of Signature')
            ->addMember($firstMember)
            ->addMember($secondMember);

         /** @var Wdhaoui\Yousign\Model\Procedure */
        $procedure = $signature->initProcedure($procedure, $file);
            
        return new Response($serializer->serialize($procedure, 'json'), 201, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Route("/get", name="get")
     */
    public function get(string $procedureId, Signature $signature, SerializerInterface $serializer)
    {
        $procedure = $signature->getProcedure($procedureId);
        
        return new Response($serializer->serialize($procedure, 'json'), 200, ['Content-Type' => 'application/json']);
    }
}
```
Response

```
{
    "id": "/procedures/7debebda-57f8-4277-9b78-ac7f54e92eb2",
    "name": "name",
    "description": "description of Signature,
    "createdAt": "2019-04-19T09:32:13+02:00",
    "updatedAt": "2019-04-19T09:32:13+02:00",
    "finishedAt": null,
    "expiresAt": null,
    "status": "active",
    "creator": null,
    "creatorFirstName": null,
    "creatorLastName": null,
    "company": "/companies/7ba04965-cb3d-49f7-97cb-20d6e376dd39",
    "members": [
        {
            "id": "/members/2f45ffbf-a806-4bd5-8e2a-cf2d5a2f7ca3",
            "type": "signer",
            "firstname": "John",
            "lastname": "Doe",
            "email": "john.doe@email.com",
            "phone": "+33601010101",
            "position": 1,
            "createdAt": "2019-04-19T09:32:13+02:00",
            "updatedAt": "2019-04-19T09:32:13+02:00",
            "finishedAt": null,
            "status": "pending",
            "fileObjects": [
                {
                    "id": "/file_objects/7caa86f7-9f5e-48e0-b90f-8a3310bfc534",
                    "file": {
                        "id": "/files/5e4e19a9-cb7f-4f8b-8289-2a77be17b84c",
                        "name": "receipt.pdf",
                        "content": null,
                        "type": "signable",
                        "contentType": "application/pdf",
                        "description": null,
                        "createdAt": "2019-04-19T09:32:12+02:00",
                        "updatedAt": "2019-04-19T09:32:13+02:00",
                        "subObjects": []
                    },
                    "page": 0,
                    "position": "76,152,236,192",
                    "fieldName": null,
                    "mention": null,
                    "mention2": null,
                    "createdAt": "2019-04-19T09:32:13+02:00",
                    "updatedAt": "2019-04-19T09:32:13+02:00",
                    "subObjects": {
                        "file": "Wdhaoui\\Yousign\\Model\\File"
                    }
                }
            ],
            "subObjects": {
                "fileObjects": "Wdhaoui\\Yousign\\Model\\FileObject"
            }
        },
        {
            "id": "/members/e89e5395-0ea3-4130-9c19-a5569f28ca26",
            "type": "signer",
            "firstname": "John 2",
            "lastname": "Doe 2",
            "email": "john.doe2@email.com",
            "phone": "+33601010101",
            "position": 2,
            "createdAt": "2019-04-19T09:32:13+02:00",
            "updatedAt": "2019-04-19T09:32:13+02:00",
            "finishedAt": null,
            "status": "pending",
            "fileObjects": [
                {
                    "id": "/file_objects/486b76f5-f3b8-4898-9b73-045ce2b641f1",
                    "file": {
                        "id": "/files/5e4e19a9-cb7f-4f8b-8289-2a77be17b84c",
                        "name": "receipt.pdf",
                        "content": null,
                        "type": "signable",
                        "contentType": "application/pdf",
                        "description": null,
                        "createdAt": "2019-04-19T09:32:12+02:00",
                        "updatedAt": "2019-04-19T09:32:13+02:00",
                        "subObjects": []
                    },
                    "page": 0,
                    "position": "397,156,557,196",
                    "fieldName": null,
                    "mention": null,
                    "mention2": null,
                    "createdAt": "2019-04-19T09:32:13+02:00",
                    "updatedAt": "2019-04-19T09:32:13+02:00",
                    "subObjects": {
                        "file": "Wdhaoui\\Yousign\\Model\\File"
                    }
                }
            ],
            "subObjects": {
                "fileObjects": "Wdhaoui\\Yousign\\Model\\FileObject"
            }
        }
    ],
    "files": [
        {
            "id": "/files/5e4e19a9-cb7f-4f8b-8289-2a77be17b84c",
            "name": "receipt.pdf",
            "content": null,
            "type": "signable",
            "contentType": "application/pdf",
            "description": null,
            "createdAt": "2019-04-19T09:32:12+02:00",
            "updatedAt": "2019-04-19T09:32:13+02:00",
            "subObjects": []
        }
    ],
    "archive": false,
    "subObjects": {
        "members": "Wdhaoui\\Yousign\\Model\\Member",
        "files": "Wdhaoui\\Yousign\\Model\\File"
    }
}
```
### Feature:

- Generate iframe url
- implementation Advanced mode see (https://dev.yousign.com/#)
### External documentation

[Yousign docs](https://dev.yousign.com/#)
