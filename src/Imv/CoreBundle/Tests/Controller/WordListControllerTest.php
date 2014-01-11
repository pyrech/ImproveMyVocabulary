<?php

namespace Imv\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordListControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Check index's status code
        $crawler = $client->request('GET', '/list/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /list/");
    }

    public function testCrudScenario()
    {
        $uniqid = uniqid();
        $newName = 'New_'.$uniqid;
        $editName = 'Edit_'.$uniqid;

        $client = static::createClient();

        // Check new request's status code
        $crawler = $client->request('GET', '/list/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /list/new");

        // Fill in the form and submit it
        $form = $crawler->selectButton('imv_corebundle_wordlist_submit')->form(array(
            'imv_corebundle_wordlist[name]'  => $newName
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertEquals(0, $crawler->filter('h1:contains("'.$newName.'")')->count(), 'Missing element h1:contains("'.$newName.'")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('imv_corebundle_wordlist_submit')->form(array(
            'imv_corebundle_wordlist[name]'  => $editName
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals to $editName
        $this->assertEquals(1, $crawler->filter('[value="'.$editName.'"]')->count(), 'Missing element [value="'.$editName.'"]');

        // Delete the entity
        $client->submit($crawler->selectButton('form_submit')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/'.$editName.'/', $client->getResponse()->getContent());
    }
}
