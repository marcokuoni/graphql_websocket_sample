<?php
namespace Concrete\Package\Concrete5GraphqlWebsocketSample;

use Concrete\Core\Http\ServerInterface;
use Concrete\Core\Package\Package;
use Custom\Space\Middleware;
use Asset;
use AssetList;
use Page;
use SinglePage;
use Database;
use PageTheme;
use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;

class Controller extends Package
{

    protected $appVersionRequired = '8.5.1';
    protected $pkgVersion = '1.0.1';
    protected $pkgHandle = 'concrete5_graphql_websocket_sample';
    protected $pkgName = 'GraphQL with Websocket Sample';
    protected $pkgDescription = 'Shows how to use GraphQL and Websocket in Concrete5';
    protected $pkg;
    protected $pkgAutoloaderRegistries = array(
        'src/GraphQl' => '\GraphQl',
        'src/Entity' => '\Entity',
    );

    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/Entity' => 'Entity'
        ]);
        return $provider;
    }


    public function on_start()
    {
        // Extend the ServerInterface binding so that when concrete5 creates the http server we can add our middleware
        $this->app->extend(ServerInterface::class, function(ServerInterface $server) {
            // Add our custom middleware
            return $server->addMiddleware($this->app->make(Middleware::class));
        });

        $al = AssetList::getInstance();
        $al->register('javascript', 'person', 'js/dist/person.js', array('position' => Asset::ASSET_POSITION_FOOTER, 'minify' => false, 'combine' => true), $this);

        \GraphQl\TestGraphQl::start();
    }

    public function install()
    {
        $this->pkg = parent::install();
        self::addSampleData();
        self::installSinglePage('/person', $this->pkg);
        self::addTheme($this->pkg);
    }

    public function upgrade()
    {
        $this->pkg = parent::upgrade();

        self::addSampleData();
        self::installSinglePage('/person', $this->pkg);
        self::addTheme($this->pkg);

        return $this->pkg;
    }

    public function uninstall()
    {
        $this->removeSinglePage('/person');

        parent::uninstall();
    }

    private static function addTheme($pkg)
    {
        if (!is_object(PageTheme::getByHandle('person'))) {
            PageTheme::add('person', $pkg);
        }
    }

    private static function addSampleData()
    {
        $entityManager = Database::connection()->getEntityManager();

        $item = $entityManager->getRepository('\Entity\Person')
            ->findOneBy(array('first_name' => 'Fritz'));

        if (is_object($item) && $item->get_id() > 0) {
            $item = $entityManager->find('Entity\Person', $item->get_id());
        } else {
            $item = new \Entity\Person();
        }

        $item->setData(array(
            'first_name' => 'Fritz',
            'second_name' => 'Muster',
        ));
        $entityManager->persist($item);

        $item = $entityManager->getRepository('\Entity\Person')
            ->findOneBy(array('first_name' => 'Franz'));

        if (is_object($item) && $item->get_id() > 0) {
            $item = $entityManager->find('Entity\Person', $item->get_id());
        } else {
            $item = new \Entity\Person();
        }

        $item->setData(array(
            'first_name' => 'Franz',
            'second_name' => 'Kanns',
        ));

        $entityManager->persist($item);
        $entityManager->flush();
    }

    private static function installSinglePage($path, $pkg)
    {
        $page = Page::getByPath($path);
        if (!is_object($page) || $page->isError()) {
            SinglePage::add($path, $pkg);
        }
    }

    private function removeSinglePage($path) {
        $singlePage = Page::getByPath($path);
        if( is_object($singlePage) && intval($singlePage->getCollectionID()) ){
            $singlePage->delete();
        }
    }

}
