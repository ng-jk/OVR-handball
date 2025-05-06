<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', static function (RouteCollection $routes) {
    $routes->get('/', 'AuthController::toLogin');
    $routes->group('/OVR/handball/', ['filter' => 'userFilter:auth'], static function (RouteCollection $routes) {
        $routes->get('home', 'UserController::toHome');
        $routes->get('logout', 'UserController::logoutHandler', ['as' => 'logout']);

        $routes->group('home', static function (RouteCollection $routes) {
            $routes->get('home', 'HomeController::index', ['as' => 'home']);
            $routes->get('teamWizard', 'HomeController::teamWizard', ['as' => 'home.teamWizard']);
            $routes->get('eventWizard', 'HomeController::eventWizard', ['as' => 'home.eventWizard']);
            $routes->get('matchWizard', 'HomeController::matchWizard', ['as' => 'home.matchWizard']);

            $routes->post('downloadTeamFile', 'HomeController::downloadTeamFileHandler', ['as' => 'home.downloadTeamFile']);
            $routes->post('downloadEventFile', 'HomeController::downloadEventFileHandler', ['as' => 'home.downloadEventFile']);
            $routes->post('downloadMatchFile', 'HomeController::downloadMatchFileHandler', ['as' => 'home.downloadMatchFile']);
            $routes->post('uploadTeamWizard', 'HomeController::uploadTeamHandler', ['as' => 'home.uploadTeamWizard']);
            $routes->post('uploadEventWizard', 'HomeController::uploadEventHandler', ['as' => 'home.uploadEventWizard']);
            $routes->post('uploadMatchWizard', 'HomeController::uploadMatchHandler', ['as' => 'home.uploadMatchWizard']);
            $routes->post('uploadTeamFile', 'HomeController::uploadTeamFileHandler', ['as' => 'home.uploadTeamFile']);
            $routes->post('uploadEventFile', 'HomeController::uploadEventFileHandler', ['as' => 'home.uploadEventFile']);
            $routes->post('uploadMatchFile', 'HomeController::uploadMatchFileHandler', ['as' => 'home.uploadMatchFile']);
        });

        $routes->group('team', static function (RouteCollection $routes) {
            $routes->get('', 'TeamController::index', ['as' => 'team']);
            $routes->get('view/(:num)', 'TeamController::view/$1', ['as' => 'team.view']);
            $routes->get('edit/(:num)', 'TeamController::edit/$1', ['as' => 'team.edit']);
            $routes->get('create', 'TeamController::create', ['as' => 'team.create']);
            $routes->get('delete/(:num)', 'TeamController::delete/$1', ['as' => 'team.delete']);
            $routes->get('restore/(:num)', 'TeamController::restore/$1', ['as' => 'team.restore']);

            $routes->post('edit/(:num)', 'TeamController::editHandler/$1', ['as' => 'team.edit.handler']);
            $routes->post('create', 'TeamController::createHandler', ['as' => 'team.create.handler']);

            $routes->group('player', static function (RouteCollection $routes) {
                $routes->get('view/(:num)', 'PlayerController::view/$1', ['as' => 'team.player.view']);
                $routes->get('edit/(:num)', 'PlayerController::edit/$1', ['as' => 'team.player.edit']);
                $routes->get('create/(:num)', 'PlayerController::create/$1', ['as' => 'team.player.create']);
                $routes->get('delete/(:num)', 'PlayerController::delete/$1', ['as' => 'team.player.delete']);
                $routes->get('restore/(:num)', 'PlayerController::restore/$1', ['as' => 'team.player.restore']);

                $routes->post('edit/(:num)', 'PlayerController::editHandler/$1', ['as' => 'team.player.edit.handler']);
                $routes->post('create', 'PlayerController::createHandler', ['as' => 'team.player.create.handler']);
            });

            $routes->group('official', static function (RouteCollection $routes) {
                $routes->get('view/(:num)', 'OfficialController::view/$1', ['as' => 'team.official.view']);
                $routes->get('edit/(:num)', 'OfficialController::edit/$1', ['as' => 'team.official.edit']);
                $routes->get('create/(:num)', 'OfficialController::create/$1', ['as' => 'team.official.create']);
                $routes->get('delete/(:num)', 'OfficialController::delete/$1', ['as' => 'team.official.delete']);
                $routes->get('restore/(:num)', 'OfficialController::restore/$1', ['as' => 'team.official.restore']);

                $routes->post('edit/(:num)', 'OfficialController::editHandler/$1', ['as' => 'team.official.edit.handler']);
                $routes->post('create', 'OfficialController::createHandler', ['as' => 'team.official.create.handler']);
            });
        });

        $routes->group('event', static function (RouteCollection $routes) {
            $routes->get('', 'EventController::index', ['as' => 'event']);
            $routes->get('view/(:num)', 'EventController::view/$1', ['as' => 'event.view']);
            $routes->get('edit/(:num)', 'EventController::edit/$1', ['as' => 'event.edit']);
            $routes->get('create', 'EventController::create', ['as' => 'event.create']);
            $routes->get('delete/(:num)', 'EventController::delete/$1', ['as' => 'event.delete']);
            $routes->get('restore/(:num)', 'EventController::restore/$1', ['as' => 'event.restore']);

            $routes->post('edit/(:num)', 'EventController::editHandler/$1', ['as' => 'event.edit.handler']);
            $routes->post('create', 'EventController::createHandler', ['as' => 'event.create.handler']);

            $routes->group('team', static function (RouteCollection $routes) {
                $routes->get('view/(:num)', 'EventTeamController::view/$1', ['as' => 'event.team.view']);
                $routes->get('edit/(:num)', 'EventTeamController::edit/$1', ['as' => 'event.team.edit']);
                $routes->get('create/(:num)', 'EventTeamController::create/$1', ['as' => 'event.team.create']);
                $routes->get('delete/(:num)', 'EventTeamController::delete/$1', ['as' => 'event.team.delete']);
                $routes->get('restore/(:num)', 'EventTeamController::restore/$1', ['as' => 'event.team.restore']);

                $routes->post('edit/(:num)', 'EventTeamController::editHandler/$1', ['as' => 'event.team.edit.handler']);
                $routes->post('create', 'EventTeamController::createHandler', ['as' => 'event.team.create.handler']);

                $routes->group('player', static function (RouteCollection $routes) {
                    $routes->get('view/(:num)', 'EventPlayerController::view/$1', ['as' => 'event.team.player.view']);
                    $routes->get('edit/(:num)', 'EventPlayerController::edit/$1', ['as' => 'event.team.player.edit']);
                    $routes->get('create/(:num)', 'EventPlayerController::create/$1', ['as' => 'event.team.player.create']);
                    $routes->get('delete/(:num)', 'EventPlayerController::delete/$1', ['as' => 'event.team.player.delete']);
                    $routes->get('restore/(:num)', 'EventPlayerController::restore/$1', ['as' => 'event.team.player.restore']);

                    $routes->post('edit/(:num)', 'EventPlayerController::editHandler/$1', ['as' => 'event.team.player.edit.handler']);
                    $routes->post('create', 'EventPlayerController::createHandler', ['as' => 'event.team.player.create.handler']);
                });
            });

            $routes->group('partner', static function (RouteCollection $routes) {
                $routes->get('view/(:num)', 'PartnerController::view/$1', ['as' => 'event.partner.view']);
                $routes->get('edit/(:num)', 'PartnerController::edit/$1', ['as' => 'event.partner.edit']);
                $routes->get('create/(:num)', 'PartnerController::create/$1', ['as' => 'event.partner.create']);
                $routes->get('delete/(:num)', 'PartnerController::delete/$1', ['as' => 'event.partner.delete']);
                $routes->get('restore/(:num)', 'PartnerController::restore/$1', ['as' => 'event.partner.restore']);

                $routes->post('edit/(:num)', 'PartnerController::editHandler/$1', ['as' => 'event.partner.edit.handler']);
                $routes->post('create', 'PartnerController::createHandler', ['as' => 'event.partner.create.handler']);
            });

            $routes->group('official', static function (RouteCollection $routes) {
                $routes->get('view/(:num)', 'EventOfficialController::view/$1', ['as' => 'event.official.view']);
                $routes->get('edit/(:num)', 'EventOfficialController::edit/$1', ['as' => 'event.official.edit']);
                $routes->get('create/(:num)', 'EventOfficialController::create/$1', ['as' => 'event.official.create']);
                $routes->get('delete/(:num)', 'EventOfficialController::delete/$1', ['as' => 'event.official.delete']);
                $routes->get('restore/(:num)', 'EventOfficialController::restore/$1', ['as' => 'event.official.restore']);

                $routes->post('edit/(:num)', 'EventOfficialController::editHandler/$1', ['as' => 'event.official.edit.handler']);
                $routes->post('create', 'EventOfficialController::createHandler', ['as' => 'event.official.create.handler']);
            });

            $routes->group('match', static function (RouteCollection $routes) {
                $routes->get('', 'MatchController::index', ['as' => 'event.match']);
                $routes->get('view/(:num)', 'MatchController::view/$1', ['as' => 'event.match.view']);
                $routes->get('view/detail/(:num)', 'MatchController::viewDetail/$1', ['as' => 'event.match.view.detail']);
                $routes->get('edit/(:num)', 'MatchController::edit/$1', ['as' => 'event.match.edit']);
                $routes->get('create/(:num)', 'MatchController::create/$1', ['as' => 'event.match.create']);
                $routes->get('delete/(:num)', 'MatchController::delete/$1', ['as' => 'event.match.delete']);
                $routes->get('restore/(:num)', 'MatchController::restore/$1', ['as' => 'event.match.restore']);
                $routes->get('generate/(:num)', 'MatchController::generate/$1', ['as' => 'event.match.generate']);
                $routes->post('edit/(:num)', 'MatchController::editHandler/$1', ['as' => 'event.match.edit.handler']);
                $routes->post('create/(:num)', 'MatchController::createHandler/$1', ['as' => 'event.match.create.handler']);

                $routes->group('team', static function (RouteCollection $routes) {
                    $routes->get('view/(:num)', 'MatchTeamController::view/$1', ['as' => 'event.match.team.view']);
                    $routes->get('edit/(:num)', 'MatchTeamController::edit/$1', ['as' => 'event.match.team.edit']);
                    $routes->get('delete/(:num)', 'MatchTeamController::delete/$1', ['as' => 'event.match.team.delete']);
                    $routes->get('restore/(:num)', 'MatchTeamController::restore/$1', ['as' => 'event.match.team.restore']);

                    $routes->post('edit/(:num)', 'MatchTeamController::editHandler/$1', ['as' => 'event.match.team.edit.handler']);
                    $routes->post('create', 'MatchTeamController::createHandler', ['as' => 'event.match.team.create.handler']);

                    $routes->group('player', static function (RouteCollection $routes) {
                        $routes->get('(:num)', 'MatchPlayerController::index/$1', ['as' => 'event.match.team.player']);
                        $routes->get('view/(:num)', 'MatchPlayerController::view/$1', ['as' => 'event.match.team.player.view']);
                        $routes->get('edit/(:num)', 'MatchPlayerController::edit/$1', ['as' => 'event.match.team.player.edit']);
                        $routes->get('create/(:num)', 'MatchPlayerController::create/$1', ['as' => 'event.match.team.player.create']);
                        $routes->get('delete/(:num)', 'MatchPlayerController::delete/$1', ['as' => 'event.match.team.player.delete']);
                        $routes->get('restore/(:num)', 'MatchPlayerController::restore/$1', ['as' => 'event.match.team.player.restore']);

                        $routes->post('edit/(:num)', 'MatchPlayerController::editHandler/$1', ['as' => 'event.match.team.player.edit.handler']);
                        $routes->post('create', 'MatchPlayerController::createHandler', ['as' => 'event.match.team.player.create.handler']);

                        $routes->group('penalty', static function (RouteCollection $routes) {
                            $routes->get('(:num)', 'PenaltyController::index/$1', ['as' => 'event.match.team.player.penalty']);
                            $routes->get('view/(:num)', 'PenaltyController::view/$1', ['as' => 'event.match.team.player.penalty.view']);
                            $routes->get('edit/(:num)', 'PenaltyController::edit/$1', ['as' => 'event.match.team.player.penalty.edit']);
                            $routes->get('create/(:num)', 'PenaltyController::create/$1', ['as' => 'event.match.team.player.penalty.create']);
                            $routes->get('delete/(:num)', 'PenaltyController::delete/$1', ['as' => 'event.match.team.player.penalty.delete']);
                            $routes->get('restore/(:num)', 'PenaltyController::restore/$1', ['as' => 'event.match.team.player.penalty.restore']);

                            $routes->post('edit/(:num)', 'PenaltyController::editHandler/$1', ['as' => 'event.match.team.player.penalty.edit.handler']);
                            $routes->post('create/(:num)', 'PenaltyController::createHandler/$1', ['as' => 'event.match.team.player.penalty.create.handler']);
                        });
                        $routes->group('shot', static function (RouteCollection $routes) {
                            $routes->get('(:num)', 'ShotController::index/$1', ['as' => 'event.match.team.player.shot']);
                            $routes->get('view/(:num)', 'ShotController::view/$1', ['as' => 'event.match.team.player.shot.view']);
                            $routes->get('edit/(:num)', 'ShotController::edit/$1', ['as' => 'event.match.team.player.shot.edit']);
                            $routes->get('create/(:num)', 'ShotController::create/$1', ['as' => 'event.match.team.player.shot.create']);
                            $routes->get('delete/(:num)', 'ShotController::delete/$1', ['as' => 'event.match.team.player.shot.delete']);
                            $routes->get('restore/(:num)', 'ShotController::restore/$1', ['as' => 'event.match.team.player.shot.restore']);

                            $routes->post('edit/(:num)', 'ShotController::editHandler/$1', ['as' => 'event.match.team.player.shot.edit.handler']);
                            $routes->post('create/(:num)', 'ShotController::createHandler/$1', ['as' => 'event.match.team.player.shot.create.handler']);
                        });
                        $routes->group('save', static function (RouteCollection $routes) {
                            $routes->get('(:num)', 'SaveController::index/$1', ['as' => 'event.match.team.player.save']);
                            $routes->get('view/(:num)', 'SaveController::view/$1', ['as' => 'event.match.team.player.save.view']);
                            $routes->get('edit/(:num)', 'SaveController::edit/$1', ['as' => 'event.match.team.player.save.edit']);
                            $routes->get('create/(:num)', 'SaveController::create/$1', ['as' => 'event.match.team.player.save.create']);
                            $routes->get('delete/(:num)', 'SaveController::delete/$1', ['as' => 'event.match.team.player.save.delete']);
                            $routes->get('restore/(:num)', 'SaveController::restore/$1', ['as' => 'event.match.team.player.save.restore']);                            $routes->post('edit/(:num)', 'SaveController::editHandler/$1', ['as' => 'event.match.team.player.save.edit.handler']);
                            $routes->post('create/(:num)', 'SaveController::createHandler/$1', ['as' => 'event.match.team.player.save.create.handler']);
                        });
                    });

                    $routes->group('official', static function (RouteCollection $routes) {
                        $routes->get('view/(:num)', 'MatchOfficialController::view/$1', ['as' => 'event.match.team.official.view']);
                        $routes->get('edit/(:num)', 'MatchOfficialController::edit/$1', ['as' => 'event.match.team.official.edit']);
                        $routes->get('create/(:num)', 'MatchOfficialController::create/$1', ['as' => 'event.match.team.official.create']);
                        $routes->get('delete/(:num)', 'MatchOfficialController::delete/$1', ['as' => 'event.match.team.official.delete']);
                        $routes->get('restore/(:num)', 'MatchOfficialController::restore/$1', ['as' => 'event.match.team.official.restore']);

                        $routes->post('edit/(:num)', 'MatchOfficialController::editHandler/$1', ['as' => 'event.match.team.official.edit.handler']);
                        $routes->post('create', 'MatchOfficialController::createHandler', ['as' => 'event.match.team.official.create.handler']);
                    });
                });
            });
        });
    });
});
$routes->group('', ['filter' => 'userFilter:guest'], static function (RouteCollection $routes) {
    $routes->get('/', 'AuthController::loginForm');
    $routes->get('login', 'AuthController::loginForm',  ['as' => 'login']);
    $routes->post('login', 'AuthController::loginHandler', ['as' => 'login.handler']);

    $routes->group('report', static function (RouteCollection $routes) {
        $routes->get('', 'ReportController::reportView', ['as' => 'report']);
        $routes->post('print', 'ReportController::printReport', ['as' => 'report.print']);
    });
});
