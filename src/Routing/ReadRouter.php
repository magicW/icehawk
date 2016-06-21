<?php
/**
 * @author hollodotme
 */

namespace Fortuneglobe\IceHawk\Routing;

use Fortuneglobe\IceHawk\Constants\HandlerMethodInterfaceMap;
use Fortuneglobe\IceHawk\Exceptions\UnresolvedRequest;
use Fortuneglobe\IceHawk\Interfaces\ProvidesRequestInfo;
use Fortuneglobe\IceHawk\Interfaces\RoutesToReadHandler;

/**
 * Class ReadRouter
 * @package Fortuneglobe\IceHawk\Routing
 */
final class ReadRouter extends AbstractRouter
{
	/**
	 * @param ProvidesRequestInfo $requestInfo
	 *
	 * @throws UnresolvedRequest
	 * @return RoutesToReadHandler
	 */
	public function findMatchingRoute( ProvidesRequestInfo $requestInfo ) : RoutesToReadHandler
	{
		$requiredHandlerType = HandlerMethodInterfaceMap::HTTP_METHODS[ $requestInfo->getMethod() ];

		foreach ( $this->getRoutes() as $route )
		{
			if ( !($route instanceof RoutesToReadHandler) )
			{
				continue;
			}

			if ( $route->matches( $requestInfo ) && $route->getRequestHandler() instanceof $requiredHandlerType  )
			{
				return $route;
			}
		}

		throw ( new UnresolvedRequest() )->withRequestInfo( $requestInfo );
	}
}