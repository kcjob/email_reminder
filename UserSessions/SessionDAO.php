<?php
namespace UserSessions;
use UserSessions\Session;


class SessionDAO{
	static function getSessionData($connectToDb) {
		$state=1;
		$allUsers = array();

/*
		$queryInfo = "select CU.id AS Id, CU.email AS userEmail, CS.name AS equipment, concat(CU.firstname, ' ', cu.lastname) AS user, DATA(CTA.start) AS date, TIME(CTA.start) AS start, TIME(CTA.end) AS end
		FROM core_timed_activity AS CTA, core_services AS CS, core_users AS CU
		WHERE CTA.start >= now() and CTA.start < convert((current_date() + interval 1 day),datetime) and CTA.state = ? and CTA.user = CU.id
		ORDER BY CU.id, CTA.start LIMIT 10";
*/
		$queryInfo = "SELECT CU.id AS Id, CU.email AS userEmail, CS.name AS equipment, concat(CU.firstname, ' ', CU.lastname) AS user, DATE(CTA.start) as date, TIME(CTA.start) AS start, TIME(CTA.end) as end
		FROM core_timed_activity AS CTA, core_services AS CS, core_users AS CU
		WHERE CTA.service_id = CS.id AND cta.state = ? and cta.user = cu.id
		ORDER BY CU.id, CTA.start LIMIT 10";


		$queryInfoResults = $connectToDb->prepare($queryInfo);
		if(!$queryInfoResults){
			throw new \Exception('Querry failed');
		}

  	$queryInfoResults -> bind_param("i", $state);
  	$queryInfoResults -> execute();
  	$queryInfoResults -> bind_result($id, $email, $equipment, $user, $date, $start, $end);

		//Create an array of each user as objects
		while($queryInfoResults -> fetch()){
			//print strtotime($date);
			$newDate = DATE('D, j, M Y', strtotime($date));
			//print $newDate;
			$obj = new Session($id, $email, $equipment, $user, $newDate, $start, $end);
			$allSessions[] = $obj;
		}
		return $allSessions;
 	}

}
//UsersDAO::getUserData();
