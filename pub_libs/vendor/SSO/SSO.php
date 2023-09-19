<?php
/**
 * SSO - Utility library for authentication with SSO-UI
 *
 * @author      Bobby Priambodo <bobby.priambodo@gmail.com>
 * @copyright   2015 Bobby Priambodo
 * @license     MIT
 * @package     SSO
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 		
namespace SSO;

use phpCAS;

/**
 * The SSO class is a simple phpCAS interface for authenticating using
 * SSO-UI CAS service.
 *
 * @class     SSO
 * @category  Authentication
 * @package   SSO 
 * @author    Bobby Priambodo <bobby.priambodo@gmail.com>
 * @license   MIT
 */
class SSO
{

  /**
   * Authenticate the user.
   *
   * @return bool Authentication
   */
  public static function authenticate() {
    return phpCAS::forceAuthentication();
  }
  
  

  /**
   * Check if the user is already authenticated.
   *
   * @return bool Authentication
   */
  public static function check() {
    return phpCAS::checkAuthentication();
  }

  /**
   * Logout from SSO with URL redirection options
   */
  public static function logout($url='') {
    if ($url === ''){
      phpCAS::logout();	  
	  header('Location: ?login');
    }else{
      phpCAS::logout(['url' => $url]);
	  header('Location: ?login');
	  }
  }

  /**
   * Returns the authenticated user.
   *
   * @return Object User
   */
  public static function getUser() {
	  
	$string=exec('getmac');
	$macAddr=substr($string, 0, 17); 
	$ipAddr = $_SERVER['REMOTE_ADDR'];
	$userid = phpCAS::getUser();							
							
	//$conn = oci_connect('DBADMIN', 'Fhska2xkD3', '192.168.100.249/ORCL');
	//$conn = oci_connect('DBADMIN', 'Fhska2xkD3', 'cmsolusi.com/ORCL');
	
	$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.30.12)(PORT = 1521)))(CONNECT_DATA=(SID=sardb)))";
    $conn = oci_connect('DBADMIN', 'Fhska2xkD3', $db);
	
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$stid = oci_parse($conn, "SELECT USERID, ID_PEGAWAI, NIP, NIP_LAMA, NAMA_LENGKAP, GELAR_D, GELAR_B, JABATAN, KDUNOR, KDPARENT, KDSATKER, NMSATKER, N_FILE FROM DBADMIN.VMUSER  WHERE USERID = '$userid'");
	oci_execute($stid);
	$details = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
	$stid2 = oci_parse($conn, "SELECT A.T_SESSIONEXP FROM DBADMIN.TMSESSIONEXP A");
	oci_execute($stid2);
	$details2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	$stid3 = oci_parse($conn, "select a.USERID, d.ID_APLIKASI, d.C_OTORITAS from TMUSER a join TPEGAWAI b on (a.NIP = b.NIP) left join TRSATKER c on (a.KDSATKER = c.KDSATKER) left join TMOTORITAS d on (a.USERID = d.USERID) where a.USERID = '$userid'");
	oci_execute($stid3);
	$details3 = oci_fetch_all($stid3,$res);
	  
	if($res){
				for($s=0; $s<sizeof($res['USERID']); $s++){
					$userid2 = $res['USERID'][$s];
					$idAplikasi = $res['ID_APLIKASI'][$s];
					$cOtoritas = $res['C_OTORITAS'][$s];
					
					$otoritas[$s] = array("id_aplikasi" => $idAplikasi,
										  "c_otoritas" => $cOtoritas,
										  );
				}
			}
	
	$fotoProfileName = $details['N_FILE'];
						
	if($fotoProfileName != 'default.png'){
		$fotoProfileURL = "http://dev.cmsolusi.com/sso/publik/img/profile/".$fotoProfileName;
	} else {
		$fotoProfileURL = "http://dev.cmsolusi.com/sso/img/default.png";
	}
	
						
						
    // Create new user object, initially empty.
    $user = new \stdClass();
    $user->username = phpCAS::getUser();
    $user->id_pegawai = $details['ID_PEGAWAI'];
    $user->nip = $details['NIP'];
    $user->nip_lama = $details['NIP_LAMA'];
    $user->nama_lengkap = $details['NAMA_LENGKAP'];
	$user->jabatan = $details['JABATAN'];
	$user->kdunor = $details['KDUNOR'];
    $user->kdparent = $details['KDPARENT'];
	$user->kdsatker = $details['KDSATKER'];
	$user->nmsatker = $details['NMSATKER'];
	$user->fotoProfile = $fotoProfileURL;
	$user->ipAddr = $ipAddr;
	$user->macAddr = $macAddr;
	$user->otoritas = $otoritas;  
	$user->tSessionexp = $details2['T_SESSIONEXP'];
	$user->sessionid = session_id();

    return $user;
  }

  // ----------------------------------------------------------
  // Manual Installation Stuff
  // ----------------------------------------------------------

  /**
   * Sets the path to CAS.php. Use only when not installing via Composer.
   *
   * @param string $cas_path Path to CAS.php
   */
  public static function setCASPath($cas_path) {
    require $cas_path;

    // Initialize CAS client.
    self::init();
  }

  /**
   * Initialize CAS client. Called by setCASPath().
   */
  private static function init() {
    // Create CAS client.
    phpCAS::client(CAS_VERSION_2_0, CAS_SERVER_HOST, CAS_SERVER_PORT, CAS_SERVER_URI);

    // Set no validation.
    phpCAS::setNoCasServerValidation();
  }

}
