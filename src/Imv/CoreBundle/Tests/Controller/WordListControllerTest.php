<?php

namespace Imv\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WordListControllerTest extends WebTestCase
{
    public function testCrudScenario()
    {
        $client = static::createClient();

        // Check index's status code
        $crawler = $client->request('GET', '/list/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /list/");

        $uniqid = uniqid();
        $newName = 'New_'.$uniqid;
        $editName = 'Edit_'.$uniqid;

        $client = static::createClient();

        // Check new request's status code
        $crawler = $client->click($crawler->filter('.btn-new')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET new page");

        // Fill in the form and submit it
        $form = $crawler->filter('.btn-create')->form(array(
            'imv_corebundle_wordlist[name]'  => $newName
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check show request's status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET show page");

        // Check data in the show view
        $this->assertEquals(0, $crawler->filter('h1:contains("'.$newName.'")')->count(), 'Missing element h1:contains("'.$newName.'")');

        // Check edit request's status code
        $crawler = $client->click($crawler->filter('.btn-edit')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET edit page");

        $form = $crawler->filter('.btn-update')->form(array(
            'imv_corebundle_wordlist[name]'  => $editName
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check edit request's status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET edit page");

        // Check the element contains an attribute with value equals to $editName
        $this->assertEquals(1, $crawler->filter('[value="'.$editName.'"]')->count(), 'Missing element [value="'.$editName.'"]');

        // Delete the entity
        $client->submit($crawler->filter('.btn-delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/'.$editName.'/', $client->getResponse()->getContent());
    }
}
