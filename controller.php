<?php

namespace Concrete\Package\Concrete5GraphqlWebsocketSample;

use Asset;
use AssetList;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;
use Concrete\Core\Package\Package;
use Database;
use Page;
use PageTheme;
use SinglePage;

class Controller extends Package
{
    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::$packageDependencies
     */
    protected $packageDependencies = [
        'concrete5_graphql_websocket' => '1.2.3',
    ];
    protected $appVersionRequired = '8.5.1';
    protected $pkgVersion = '1.1.3';
    protected $pkgHandle = 'concrete5_graphql_websocket_sample';
    protected $pkgName = 'GraphQL with Websocket Sample';
    protected $pkgDescription = 'Shows how to use GraphQL and Websocket in Concrete5';
    protected $pkg;
    protected $pkgAutoloaderRegistries = [
        'src/GraphQl' => '\GraphQl',
        'src/Entity' => '\Entity',
    ];

    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/Entity' => 'Entity',
        ]);

        return $provider;
    }

    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register('javascript', 'person', 'js/dist/person.js', ['position' => Asset::ASSET_POSITION_FOOTER, 'minify' => false, 'combine' => true], $this);

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
            ->findOneBy(['first_name' => 'Fritz']);

        if (is_object($item) && $item->get_id() > 0) {
            $item = $entityManager->find('Entity\Person', $item->get_id());
        } else {
            $item = new \Entity\Person();
        }

        $item->setData([
            'first_name' => 'Fritz',
            'second_name' => 'Muster',
        ]);
        $entityManager->persist($item);

        $item = $entityManager->getRepository('\Entity\Person')
            ->findOneBy(['first_name' => 'Franz']);

        if (is_object($item) && $item->get_id() > 0) {
            $item = $entityManager->find('Entity\Person', $item->get_id());
        } else {
            $item = new \Entity\Person();
        }

        $item->setData([
            'first_name' => 'Franz',
            'second_name' => 'Kanns',
        ]);

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
        if(is_object($singlePage) && (int) ($singlePage->getCollectionID())){
            $singlePage->delete();
        }
    }
}
