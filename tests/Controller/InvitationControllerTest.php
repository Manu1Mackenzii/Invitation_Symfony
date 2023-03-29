<?php

namespace App\Test\Controller;

use App\Entity\Invitation;
use App\Repository\InvitationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private InvitationRepository $repository;
    private string $path = '/invitation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Invitation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Invitation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'invitation[expediteur]' => 'Testing',
            'invitation[receveur]' => 'Testing',
            'invitation[statut]' => 'Testing',
        ]);

        self::assertResponseRedirects('/invitation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Invitation();
        $fixture->setExpediteur('My Title');
        $fixture->setReceveur('My Title');
        $fixture->setStatut('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Invitation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Invitation();
        $fixture->setExpediteur('My Title');
        $fixture->setReceveur('My Title');
        $fixture->setStatut('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'invitation[expediteur]' => 'Something New',
            'invitation[receveur]' => 'Something New',
            'invitation[statut]' => 'Something New',
        ]);

        self::assertResponseRedirects('/invitation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getExpediteur());
        self::assertSame('Something New', $fixture[0]->getReceveur());
        self::assertSame('Something New', $fixture[0]->getStatut());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Invitation();
        $fixture->setExpediteur('My Title');
        $fixture->setReceveur('My Title');
        $fixture->setStatut('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/invitation/');
    }
}
