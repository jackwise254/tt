<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
// use App\Models\Barcode39;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Libraries\Barcode39;

  
class Warranty extends Controller
{
    public function index()
    {
        $session = session();
        echo "Hello : ".$session->get('name');
    }
      //loading warranty csv page
      public function wload()
      {
          
          $db      = \Config\Database::connect();
          $builder = $db->table('wtemplist');
          $builder->select('wtemplist.*');
          $data['wtemplist'] = $builder->get()->getResult();
  
          $cart = array();
          $cart2 = array();
          $cart4 = array();
  
  
          foreach($data['wtemplist'] as $p){
              $m = $p->del;
              $cart[] = $m; 
          }
  
          $data2['single'] = array_unique($cart);
          
          foreach($data2['single'] as $s){
          $singles = $s;
          $cart2 = 0;
  
          $builder = $db->table('wtemplist');
          $builder->select('wtemplist.*');
          $builder->where('wtemplist.del', $singles);
          $data3 = $builder->get()->getResult();
          $cart2 = $data3;
  
          $array = json_decode(json_encode($cart2[0]), true);
          $cat[] = $array;
          $cart4['all'] = $cat;
          }
          if($cart4 != []){
            $session = \Config\Services::session();

        $db      = \Config\Database::connect();

        $builder1 = $db->table('users');
        $builder1->select('users.*');
        $builder1->where('users.designation = "admin" ' );
        $sdata['hello'] = $builder1->get()->getResultArray();
        $session->set($sdata);
        $cart4['user_data'] = $session->get('designation');

            
            $db      = \Config\Database::connect();
            $builder = $db->table('customer');
            $builder->select('customer.*')->orderBy('username', 'ASC');
             $cart4['user_data'] = $session->get('designation');

            $cart4['customer'] = $builder->get()->getResult();
              return view('products/wuploadCsv', $cart4);
          }else{
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $cart4['user_data'] = $session->get('designation');
              $cart4['all'] = $cart;
              $db      = \Config\Database::connect();
                $builder = $db->table('customer');
                $builder->select('customer.*')->orderBy('username', 'ASC');
                 $cart4['user_data'] = $session->get('designation');

                $cart4['customer'] = $builder->get()->getResult();
              return view('products/wuploadCsv', $cart4);
          }
          
      }

      //calling warranty in form
      public function wcreate(){

        $session = \Config\Services::session();

        $db      = \Config\Database::connect();

        $builder1 = $db->table('users');
        $builder1->select('users.*');
        $builder1->where('users.designation = "admin" ' );
        $sdata['hello'] = $builder1->get()->getResultArray();
        $session->set($sdata);
        $cart4['user_data'] = $session->get('designation');
        
        $db      = \Config\Database::connect();
        
        $builder1 = $db->table('condition');
        $builder1->select('condition.*');
        $cart4['condition'] = $builder1->get()->getResult();

        $builder2 = $db->table('brand');
        $builder2->select('brand.*');
        $cart4['brand'] = $builder2->get()->getResult();

        $builder3 = $db->table('type');
        $builder3->select('type.*');
        $cart4['type'] = $builder3->get()->getResult();


        $builder4 = $db->table('Gen');
        $builder4->select('Gen.*');
        $cart4['gen'] = $builder4->get()->getResult();



        $builder5 = $db->table('Cpu');
        $builder5->select('Cpu.*');
        $cart4['cpu'] = $builder5->get()->getResult();

        $builder6 = $db->table('Speed');
        $builder6->select('Speed.*');
        $cart4['speed'] = $builder6->get()->getResult();

        $builder7 = $db->table('Ram');
        $builder7->select('Ram.*');
        $cart4['ram'] = $builder7->get()->getResult();

        $builder8 = $db->table('Hdd');
        $builder8->select('Hdd.*');
        $cart4['hdd'] = $builder8->get()->getResult();

        $builder9 = $db->table('Screen');
        $builder9->select('Screen.*');
        $cart4['screen'] = $builder9->get()->getResult();

        $builder10 = $db->table('customer');
        $builder10->select('customer.*');
        $cart4['customer'] = $builder10->get()->getResult();

        return view('/products/add_wproducts', $cart4);



    }

        public function wstore() {
        helper('html');
        $del = rand(10000000, 99999999);
        $db      = \Config\Database::connect();
        $builder = $db->table('wtemplist');
        require ('../vendor/autoload.php');
        $qty = $this->request->getVar('qty');
        $daterecieved = $this->request->getVar('daterecieved');
        // echo '<pre>';
        // print_r($daterecieved);
        // exit;
          if($this->request->getvar('daterecieved')){
            // $data['daterecieved'] = $this->request->getvar('daterecieved');

            $data = [
              'conditions' => $this->request->getVar('conditions'),
              'type' => $this->request->getVar('type'),
              'del' => $del,
              'random' => $del,
              'daterecieved' => $this->request->getVar('daterecieved'),
              'gen' => $this->request->getVar('gen'),
              'ram' => $this->request->getVar('ram'),
              'brand' => $this->request->getVar('brand'),
              'screen' => $this->request->getVar('screen'),
              'part' => $this->request->getVar('part'),
              'serialno' => $this->request->getVar('serialno'),
              'modelid' => $this->request->getVar('modelid'),
              'model' => $this->request->getVar('model'),
              'cpu' => $this->request->getVar('cpu'),
              'speed' => $this->request->getVar('speed'),
              'price' => $this->request->getVar('price'),
              'hdd' => $this->request->getVar('hdd'),
              'list' => $this->request->getVar('list'),
              'odd' => $this->request->getVar('odd'),
              'comment' => $this->request->getVar('comment'),
              'total' => $this->request->getVar('qty'),
              'problem' => $this->request->getVar('problem'),
              'customer' => $this->request->getVar('customer'),
          ];
          }
           else{
            $data = [
              'conditions' => $this->request->getVar('conditions'),
              'type' => $this->request->getVar('type'),
              'del' => $del,
              'random' => $del,
              // 'daterecieved' => $this->request->getVar('daterecieved'),
              'gen' => $this->request->getVar('gen'),
              'ram' => $this->request->getVar('ram'),
              'brand' => $this->request->getVar('brand'),
              'screen' => $this->request->getVar('screen'),
              'part' => $this->request->getVar('part'),
              'serialno' => $this->request->getVar('serialno'),
              'modelid' => $this->request->getVar('modelid'),
              'model' => $this->request->getVar('model'),
              'cpu' => $this->request->getVar('cpu'),
              'speed' => $this->request->getVar('speed'),
              'price' => $this->request->getVar('price'),
              'hdd' => $this->request->getVar('hdd'),
              'list' => $this->request->getVar('list'),
              'odd' => $this->request->getVar('odd'),
              'comment' => $this->request->getVar('comment'),
              'total' => $this->request->getVar('qty'),
              'problem' => $this->request->getVar('problem'),
              'customer' => $this->request->getVar('customer'),
          ];
           }

        // echo '<pre>';
        // print_r($data);
        // exit;

        for ($i=0; $i <$qty; $i++) { 
           $assid = 'Wp'.rand(100000, 999999);
            $data['assetid'] = $assid;
            $builder->insert($data);
       
        }

       
        $data1 = [
            'username' => $this->request->getVar('customer'),

        ];
        $data5 =[
            'random' => $del,
        ];

        $builder2 = $db->table("customer");
        $builder2->select('customer.*');
        $builder2->where('username', $data1['username']);
        $data3 = $builder2->get()->getResultArray();

        $builder1 = $db->table("wicustomer");
        $builder1->select('wicustomer.*');
        $builder1->where('username', $data1['username']);
        $data2 = $builder1->get()->getResultArray();

        foreach($data3 as $r) { 
          
            $db->table('wicustomer')->insert($r);
        }

        $builder1000 = $db->table("wicustomer");
        $builder1000->select('wicustomer.*');
        $builder1000->where('username', $data1['username']);
        $builder1000->update(['random' => $data5['random']]);
       
        return redirect()->to(base_url('Warranty/wload'))->with('status', 'Products Inserted succesfully');
}

//warranty out form
public function warrantyout()
{
    $session = \Config\Services::session();

        $db      = \Config\Database::connect();

        $builder1 = $db->table('users');
        $builder1->select('users.*');
        $builder1->where('users.designation = "admin" ' );
        $sdata['hello'] = $builder1->get()->getResultArray();
        $session->set($sdata);
        $data['user_data'] = $session->get('designation');

        helper(['form', 'url']);
        $db      = \Config\Database::connect();
        $builder1 = $db->table('warrantyout');
        $builder1->select('warrantyout.*');
        $data['warrantyout'] = $builder1->get()->getResult();

            $data['masterlist'] = $builder1->get()->getResult();

            $db      = \Config\Database::connect();
          $builder12 = $db->table('condition');
          $builder12->select('condition.*');
          $data['condition'] = $builder12->get()->getResult();

          $builder2 = $db->table('brand');
          $builder2->select('brand.*');
          $data['brand'] = $builder2->get()->getResult();

          $builder3 = $db->table('type');
          $builder3->select('type.*');
          $data['type'] = $builder3->get()->getResult();

            helper(['url', 'form']);
            return view('products/warrantyout', $data);
    }

//faulty stock operations
public function load()
      {
          $db      = \Config\Database::connect();
          $builder = $db->table('wtemplist');
          $builder->select('wtemplist.*');
          $data['wtemplist'] = $builder->get()->getResult();
  
          $cart = array();
          $cart2 = array();
          $cart4 = array();
  
  
          foreach($data['wtemplist'] as $p){
              $m = $p->del;
              $cart[] = $m; 
          }
  
          $data2['single'] = array_unique($cart);
          
          foreach($data2['single'] as $s){
          $singles = $s;
          $cart2 = 0;
  
          $builder = $db->table('wtemplist');
          $builder->select('wtemplist.*');
          $builder->where('wtemplist.del', $singles);
          $data3 = $builder->get()->getResult();
          $cart2 = $data3;
  
          $array = json_decode(json_encode($cart2[0]), true);
          $cat[] = $array;
          $cart4['all'] = $cat;
          }
          if($cart4 != []){
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $cart4['user_data'] = $session->get('designation');
              return view('products/wuploadCsv', $cart4);
          }else{
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $cart4['user_data'] = $session->get('designation');
              $cart4['all'] = $cart;
              return view('products/faultyCsv', $cart4);
          }
          
      }

      //calling warranty in form
      public function create(){
        $session = \Config\Services::session();

        $db      = \Config\Database::connect();

        $builder1 = $db->table('users');
        $builder1->select('users.*');
        $builder1->where('users.designation = "admin" ' );
        $sdata['hello'] = $builder1->get()->getResultArray();
        $session->set($sdata);
        $cart4['user_data'] = $session->get('designation');

        $db      = \Config\Database::connect();
        $builder = $db->table('dropdown');
        $builder->select('dropdown.*');
        $cart4['masterlist'] = $builder->get()->getResult();

        $db      = \Config\Database::connect();
        
        $builder1 = $db->table('condition');
        $builder1->select('condition.*');
        $cart4['condition'] = $builder1->get()->getResult();

        $builder2 = $db->table('brand');
        $builder2->select('brand.*');
        $cart4['brand'] = $builder2->get()->getResult();

        $builder3 = $db->table('type');
        $builder3->select('type.*');
        $cart4['type'] = $builder3->get()->getResult();


        $builder4 = $db->table('Gen');
        $builder4->select('Gen.*');
        $cart4['gen'] = $builder4->get()->getResult();



        $builder5 = $db->table('Cpu');
        $builder5->select('Cpu.*');
        $cart4['cpu'] = $builder5->get()->getResult();

        $builder6 = $db->table('Speed');
        $builder6->select('Speed.*');
        $cart4['speed'] = $builder6->get()->getResult();

        $builder7 = $db->table('Ram');
        $builder7->select('Ram.*');
        $cart4['ram'] = $builder7->get()->getResult();

        $builder8 = $db->table('Hdd');
        $builder8->select('Hdd.*');
        $cart4['hdd'] = $builder8->get()->getResult();

        $builder9 = $db->table('Screen');
        $builder9->select('Screen.*');
        $cart4['screen'] = $builder9->get()->getResult();

        $builder10 = $db->table('vendors');
        $builder10->select('vendors.*');
        $cart4['customer'] = $builder10->get()->getResult();

        return view('/products/add_faulty', $cart4);
    }

    public function tload()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tfaulty');
        $builder->select('tfaulty.*');
        $data['templist'] = $builder->get()->getResult();

        $cart = array();
        $cart2 = array();
        $cart4 = array();

        foreach($data['templist'] as $p){
            $m = $p->del;
            $cart[] = $m; 
        }

        $data2['single'] = array_unique($cart);
        
        foreach($data2['single'] as $s){
        $singles = $s;
        $cart2 = 0;

        $builder = $db->table('tfaulty');
        $builder->select('tfaulty.*');
        $builder->where('tfaulty.del', $singles);
        $data3 = $builder->get()->getResult();
        $cart2 = $data3;

        $array = json_decode(json_encode($cart2[0]), true);
        $cat[] = $array;
        $cart4['all'] = $cat;
        }
        if($cart4 != []){
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $cart4['user_data'] = $session->get('designation');

            $db      = \Config\Database::connect();
            $builder = $db->table('vendors');
            $builder->select('vendors.*');
            $cart4['customer'] = $builder->get()->getResult();

            return view('products/loadfaulty', $cart4);
        }else{
            $cart4['all'] = $cart;
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $cart4['user_data'] = $session->get('designation');


            $db      = \Config\Database::connect();
        $builder = $db->table('vendors');
        $builder->select('vendors.*');
        $cart4['customer'] = $builder->get()->getResult();
        }
        return view('/products/loadfaulty', $cart4);
    }

        public function store() {
        helper('html');
        $del = rand(10000000, 99999999);
        $db      = \Config\Database::connect();
        $builder = $db->table('tfaulty');
        $qty = $this->request->getVar('qty');
            $data = [
            'conditions' => $this->request->getVar('conditions'),
            'type' => $this->request->getVar('type'),
            'del' => $del,
            'gen' => $this->request->getVar('gen'),
            'ram' => $this->request->getVar('ram'),
            'brand' => $this->request->getVar('brand'),
            'screen' => $this->request->getVar('screen'),
            'part' => $this->request->getVar('part'),
            'serialno' => $this->request->getVar('serialno'),
            'modelid' => $this->request->getVar('modelid'),
            'model' => $this->request->getVar('model'),
            'cpu' => $this->request->getVar('cpu'),
            'speed' => $this->request->getVar('speed'),
            'price' => $this->request->getVar('price'),
            'hdd' => $this->request->getVar('hdd'),
            'list' => $this->request->getVar('list'),
            'daterecieved' => $this->request->getVar('daterecieved'),
            'datedelivered' => $this->request->getVar('datedelivered'),
            'odd' => $this->request->getVar('odd'),
            'comment' => $this->request->getVar('comment'),
            'problem' => $this->request->getVar('problem'),
            'vendor' => $this->request->getVar('vendor'),
        ];

        for ($i=0; $i <$qty; $i++) { 
           $assid = 'Fp'.rand(100000, 999999);
            $data['assetid'] = $assid;
            
            

            $builder->insert($data);
       
        }
       
        return redirect()->to(base_url('Warranty/tload'))->with('status', 'Products Inserted succesfully');
}
        public function summary()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
        return view('/summary/warrantyin', $data);
        }

        //   type = 'desktop' AND conditions ='New'
        public function debit()
        {

        $session = \Config\Services::session();

        $db      = \Config\Database::connect();

        $builder1 = $db->table('users');
        $builder1->select('users.*');
        $builder1->where('users.designation = "admin" ' );
        $sdata['hello'] = $builder1->get()->getResultArray();
        $session->set($sdata);
        $cart4['user_data'] = $session->get('designation');
        $date = date("Y/m/d");
        $db      = \Config\Database::connect();
        $builder1 = $db->table('debit');
        $builder1->select('debit.*')->orderBy('daterecieved', 'DESC');
        if($this->request->getGet('q')) {
         $q=$this->request->getGet('q');
        $builder1->select('debit.*');
        $builder1->like('assetid', $q);
        $builder1->orLike('brand', $q);
        $builder1->orLike('conditions', $q);
        $builder1->orLike('model', $q);
        $builder1->orLike('modelid', $q);
        $builder1->orLike('gen', $q);
        $builder1->orLike('cpu', $q);
        $builder1->orLike('screen', $q);
        $builder1->orLike('price', $q);
        $builder1->orLike('customer', $q);
        $builder1->orLike('ram', $q);
        $builder1->orLike('odd', $q);
        $builder1->orLike('comment', $q);
        $builder1->orLike('type', $q);

        $data['user_data'] = $session->get('designation');
        $data['Ndesktop'] = $builder1->get()->getResult();
        return view('/stockin/debit', $data);
           
        } elseif(!$this->request->getGet('q')) {
          $data['user_data'] = $session->get('designation');
          $data['Ndesktop'] = $builder1->get()->getResult();
      return view('/stockin/debit', $data);

        }



        

        }
        public function Ndesktop()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);

            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="desktop"' );
        if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
            $data['Ndesktop'] = $builder->get()->getResult();
            return view('/stockin/Ndesktop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Ndesktop'] = $builder->get()->getResult();
            return view('/stockin/Ndesktop', $data);
           }



        }

        public function Odesktop()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="desktop"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Udesktop'] = $builder->get()->getResult();
           return view('/stockin/Udesktop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Udesktop'] = $builder->get()->getResult();
            return view('/stockin/Udesktop', $data);
           }

        }
        public function Rdesktop()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="desktop"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rdesktop'] = $builder->get()->getResult();
            return view('/stockin/Rdesktop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rdesktop'] = $builder->get()->getResult();
            return view('/stockin/Rdesktop', $data);
           }

        }

        // new lcd
        public function Nlcd()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Lcd"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rdesktop'] = $builder->get()->getResult();
            return view('/stockin/Nlcd', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rdesktop'] = $builder->get()->getResult();
            return view('/stockin/Nlcd', $data);
           }

        }
        // end

         // Refurb lcd
         public function Rlcd()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('masterlist');
             $builder->select('masterlist.*')->orderBy('time', 'DESC');
             $builder->where('masterlist.conditions = "Refurb" AND type="Lcd"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rdesktop'] = $builder->get()->getResult();
             return view('/stockin/Rlcd', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rdesktop'] = $builder->get()->getResult();
             return view('/stockin/Rlcd', $data);
            }
 
         }
         // end

          // Used lcd
          public function Ulcd()
          {
              $session = \Config\Services::session();
  
              $db      = \Config\Database::connect();
      
              $builder1 = $db->table('users');
              $builder1->select('users.*');
              $builder1->where('users.designation = "admin" ' );
              $sdata['hello'] = $builder1->get()->getResultArray();
              $session->set($sdata);
              $data['user_data'] = $session->get('designation');
              
              $builder = $db->table('masterlist');
              $builder->select('masterlist.*')->orderBy('time', 'DESC');
              $builder->where('masterlist.conditions = "Used" AND type="Lcd"' );
              if($this->request->getGet('q')) {
              $q=$this->request->getGet('q');
             $builder->like('assetid', $q);
             $builder->orLike('brand', $q);
             $builder->orLike('conditions', $q);
             $builder->orLike('model', $q);
             $builder->orLike('modelid', $q);
             $builder->orLike('gen', $q);
             $builder->orLike('cpu', $q);
             $builder->orLike('screen', $q);
             $builder->orLike('price', $q);
             $builder->orLike('customer', $q);
             $builder->orLike('ram', $q);
             $builder->orLike('odd', $q);
             $builder->orLike('comment', $q);
             $builder->orLike('type', $q);
     
             $data['user_data'] = $session->get('designation');
             $data['Rdesktop'] = $builder->get()->getResult();
              return view('/stockin/Ulcd', $data);
                
             } elseif(!$this->request->getGet('q')) {
              $data['user_data'] = $session->get('designation');
              $data['Rdesktop'] = $builder->get()->getResult();
              return view('/stockin/Ulcd', $data);
             }
  
          }
          // end

        public function Nlaptop()
        {
            
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="laptop"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Nlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nlaptop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Nlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nlaptop', $data);
           }

        }

        public function Olaptop()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="laptop"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Ulaptop'] = $builder->get()->getResult();
           return view('/stockin/Ulaptop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Ulaptop'] = $builder->get()->getResult();
            return view('/stockin/Ulaptop', $data);
           }

        }

        public function Rlaptop()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="laptop"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rlaptop', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rlaptop', $data);
           }

        }

        // start
        public function Nimac()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nimac', $data);
           }

        }


        public function Uimac()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Uimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Uimac', $data);
           }

        }


        public function Rimac()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rimac', $data);
           }

        }


        public function Nserver()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nserver', $data);
           }

        }


        public function Userver()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Userver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Userver', $data);
           }

        }


        public function Rserver()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rserver', $data);
           }

        }


        public function Nworkstation()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nworkstation', $data);
           }

        }


        public function Uworkstation()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Uworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Uworkstation', $data);
           }

        }


        public function Rworkstation()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rworkstation', $data);
           }

        }


        public function Nmacbook()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Nmacbook', $data);
           }

        }


        public function Umacbook()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Umacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Umacbook', $data);
           }

        }


        public function Rmacbook()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/stockin/Rmacbook', $data);
           }

        }


        // end

        // start of stockout new cards
         public function Nimacs()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "New" AND type="Imac"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nimac', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nimac', $data);
            }
 
         }
 
 
         public function Umacs()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Used" AND type="Imac"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Uimac', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Uimac', $data);
            }
 
         }
 
 
         public function Rimacs()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Refurb" AND type="Imac"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rimac', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rimac', $data);
            }
 
         }
 
 
         public function Nservers()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "New" AND type="Server"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nserver', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nserver', $data);
            }
 
         }
 
 
         public function Uservers()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Used" AND type="Server"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Userver', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Userver', $data);
            }
 
         }
 
 
         public function Rservers()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Refurb" AND type="Server"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rserver', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rserver', $data);
            }
 
         }
 
 
         public function Nworkstations()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "New" AND type="Workstation"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nworkstation', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nworkstation', $data);
            }
 
         }
 
 
         public function Uworkstations()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Used" AND type="Workstation"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Uworkstation', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Uworkstation', $data);
            }
 
         }
 
 
         public function Rworkstations()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Refurb" AND type="Workstation"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rworkstation', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rworkstation', $data);
            }
 
         }
 
 
         public function Nmacbooks()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "New" AND type="Macbook"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nmacbook', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Nmacbook', $data);
            }
 
         }
 
 
         public function Umacbooks()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Used" AND type="Macbook"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Umacbook', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Umacbook', $data);
            }
 
         }
 
 
         public function Rmacbooks()
         {
             $session = \Config\Services::session();
 
             $db      = \Config\Database::connect();
     
             $builder1 = $db->table('users');
             $builder1->select('users.*');
             $builder1->where('users.designation = "admin" ' );
             $sdata['hello'] = $builder1->get()->getResultArray();
             $session->set($sdata);
             $data['user_data'] = $session->get('designation');
             
             $builder = $db->table('stockout');
             $builder->select('stockout.*')->orderBy('time', 'DESC');
             $builder->where('stockout.conditions = "Refurb" AND type="Macbook"' );
             if($this->request->getGet('q')) {
             $q=$this->request->getGet('q');
            $builder->like('assetid', $q);
            $builder->orLike('brand', $q);
            $builder->orLike('conditions', $q);
            $builder->orLike('model', $q);
            $builder->orLike('modelid', $q);
            $builder->orLike('gen', $q);
            $builder->orLike('cpu', $q);
            $builder->orLike('screen', $q);
            $builder->orLike('price', $q);
            $builder->orLike('customer', $q);
            $builder->orLike('ram', $q);
            $builder->orLike('odd', $q);
            $builder->orLike('comment', $q);
            $builder->orLike('type', $q);
    
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rmacbook', $data);
               
            } elseif(!$this->request->getGet('q')) {
             $data['user_data'] = $session->get('designation');
             $data['Rlaptop'] = $builder->get()->getResult();
             return view('/stockout/Rmacbook', $data);
            }
 
         }
 
        // end


        // start of faulty new cards
        public function Nimacf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "New" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nimac', $data);
           }

        }


        public function Umacf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Used" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Uimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Uimac', $data);
           }

        }


        public function Rimacf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Refurb" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rimac', $data);
           }

        }


        public function Nserverf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "New" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nserver', $data);
           }

        }


        public function Userverf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Used" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Userver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Userver', $data);
           }

        }


        public function Rserverf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Refurb" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rserver', $data);
           }

        }


        public function Nworkstationf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "New" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nworkstation', $data);
           }

        }


        public function Uworkstationf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Used" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Uworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Uworkstation', $data);
           }

        }


        public function Rworkstationf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Refurb" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rworkstation', $data);
           }

        }


        public function Nmacbookf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "New" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Nmacbook', $data);
           }

        }


        public function Umacbookf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Used" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Umacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Umacbook', $data);
           }

        }


        public function Rmacbookf()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Refurb" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/faulty/Rmacbook', $data);
           }

        }

       // end

        // start of warranty new cards
        public function Nimacw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "New" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nimac', $data);
           }

        }


        public function Umacw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Used" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Uimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Uimac', $data);
           }

        }


        public function Rimacw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Refurb" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rimac', $data);
           }

        }


        public function Nserverw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "New" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nserver', $data);
           }

        }


        public function Userverw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Used" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Userver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Userver', $data);
           }

        }


        public function Rserverw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Refurb" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rserver', $data);
           }

        }


        public function Nworkstationw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "New" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nworkstation', $data);
           }

        }


        public function Uworkstationw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Used" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Uworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Uworkstation', $data);
           }

        }


        public function Rworkstationw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Refurb" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rworkstation', $data);
           }

        }


        public function Nmacbookw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "New" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Nmacbook', $data);
           }

        }


        public function Umacbookw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Used" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Umacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Umacbook', $data);
           }

        }


        public function Rmacbookw()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Refurb" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warranty/Rmacbook', $data);
           }

        }

       // end

        // start of warranty out new cards
        public function Nimacwo()
        {
            $session = \Config\Services::session();
            $db      = \Config\Database::connect();
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "New" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nimac', $data);
           }

        }


        public function Umacwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Used" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Uimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Uimac', $data);
           }

        }


        public function Rimacwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Refurb" AND type="Imac"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rimac', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rimac', $data);
           }

        }


        public function Nserverwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "New" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nserver', $data);
           }

        }


        public function Userverwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Used" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Userver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Userver', $data);
           }

        }


        public function Rserverwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Refurb" AND type="Server"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rserver', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rserver', $data);
           }

        }


        public function Nworkstationwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "New" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nworkstation', $data);
           }

        }


        public function Uworkstationwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Used" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Uworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Uworkstation', $data);
           }

        }


        public function Rworkstationwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Refurb" AND type="Workstation"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rworkstation', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rworkstation', $data);
           }

        }


        public function Nmacbookwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "New" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Nmacbook', $data);
           }

        }


        public function Umacbookwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Used" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Umacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Umacbook', $data);
           }

        }


        public function Rmacbookwo()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('warrantyout');
            $builder->select('warrantyout.*')->orderBy('time', 'DESC');
            $builder->where('warrantyout.conditions = "Refurb" AND type="Macbook"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rmacbook', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rlaptop'] = $builder->get()->getResult();
            return view('/warrantyout/Rmacbook', $data);
           }

        }

       // end





        public function Nallinone()
        {
            
            $session = \Config\Services::session();
            $db      = \Config\Database::connect();
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="allinone"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/Nallinone', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/Nallinone', $data);
           }

        }

        public function smartphone()
        {
            
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="smartphone"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/smartphone', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/smartphone', $data);
           }

        }

        public function tablet()
        {
            
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="Tablet"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/tablet', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/tablet', $data);
           }

        }

        public function others()
        {
            
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="Others"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/others', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Nallinone'] = $builder->get()->getResult();
            return view('/stockin/others', $data);
           }

        }

        public function Oallinone()
        {
           
          

          $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="allinone"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Uallinone'] = $builder->get()->getResult();
          return view('/stockin/Uallinone', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
        $data['Uallinone'] = $builder->get()->getResult();
          return view('/stockin/Uallinone', $data);
           }

        }

        public function Rallinone()
        {
           
           


            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="allinone"' );

            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['Rallinone'] = $builder->get()->getResult();
            return view('/stockin/Rallinone', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['Rallinone'] = $builder->get()->getResult();
            return view('/stockin/Rallinone', $data);
           }

        }

        public function ram()
        {
        
          $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="ram"' );


            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['ram'] = $builder->get()->getResult();
           return view('/stockin/ram', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['ram'] = $builder->get()->getResult();
          return view('/stockin/ram', $data);
           }
          

        }

        public function hdd()
        {
            
          $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="hdd"' );


            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['hdd'] = $builder->get()->getResult();
           return view('/stockin/hdd', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['hdd'] = $builder->get()->getResult();
            return view('/stockin/hdd', $data);
           }
          

        }

        public function ssd()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="sdd"' );


            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['ssd'] = $builder1->get()->getResult();
           return view('/stockin/ssd', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['ssd'] = $builder1->get()->getResult();
            return view('/stockin/ssd', $data);
           }
        }


        public function printer()
        {
            $session = \Config\Services::session();

            $db      = \Config\Database::connect();
    
            $builder1 = $db->table('users');
            $builder1->select('users.*');
            $builder1->where('users.designation = "admin" ' );
            $sdata['hello'] = $builder1->get()->getResultArray();
            $session->set($sdata);
            $data['user_data'] = $session->get('designation');
            
            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="printers"' );
            if($this->request->getGet('q')) {
            $q=$this->request->getGet('q');
           $builder->like('assetid', $q);
           $builder->orLike('brand', $q);
           $builder->orLike('conditions', $q);
           $builder->orLike('model', $q);
           $builder->orLike('modelid', $q);
           $builder->orLike('gen', $q);
           $builder->orLike('cpu', $q);
           $builder->orLike('screen', $q);
           $builder->orLike('price', $q);
           $builder->orLike('customer', $q);
           $builder->orLike('ram', $q);
           $builder->orLike('odd', $q);
           $builder->orLike('comment', $q);
           $builder->orLike('type', $q);
   
           $data['user_data'] = $session->get('designation');
           $data['printer'] = $builder->get()->getResult();
           return view('/stockin/printers', $data);
              
           } elseif(!$this->request->getGet('q')) {
            $data['user_data'] = $session->get('designation');
            $data['printer'] = $builder->get()->getResult();
            return view('/stockin/printers', $data);
           }

        }
        

        public function printersp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="printer"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'printers'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'printers'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function ssdsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="sdd"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'ssd'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'ssd'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function hddsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.type="hdd"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'hdd'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'hdd'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function ramsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.type="ram"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'faultyndesktop'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'faultyndesktop'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rallinonesp()
        {
          $db      = \Config\Database::connect();

            $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rallinonesp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rallinonesp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Oallinonesp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Used" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Oallinonesp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Oallinonesp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nallinonesp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nallinonesp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nallinonesp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rlaptopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="laptop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rlaptopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rlaptopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Olaptopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="laptop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'UsedLaptop'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'UsedLaptop'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nlaptopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="laptop"' );
          
        $users = $builder->get()->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nlaptopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nlaptopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rdesktopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Refurb" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rdesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rdesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }



        public function Odesktopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Used" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Odesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Odesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        public function Ndesktopsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "New" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }
  


        public function ssdspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('type="ssd"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        public function Rallinonespot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "Refurb" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        public function Oallinonespot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "Used" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nallinonespot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "New" AND type="allinone"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rlaptopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Refurb" AND type="Laptop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rlaptop'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rlaptop'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Olaptopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Used" AND type="laptop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ulaptop'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ulaptop'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nlaptopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "New" AND type="Laptop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nlaptop'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nlaptop'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rdesktopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "Refurb" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rdesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rdesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Odesktopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "Used" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Odesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Odesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Ndesktopspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('stockout.conditions = "New" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        public function tloadspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "New" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function debitspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "New" AND type="desktop"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ndesktopsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ndesktopsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        public function ramspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where(' type="ram"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Ram'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Ram'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function hddspot()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('stockout');
          $builder->select('stockout.*')->orderBy('time', 'DESC');
          $builder->where('type', "desktop" );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Hdd'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'hdd'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        // new spreadsheets
        public function Nimacsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Imac"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Newimac'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Newimac'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Uimacsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Imac"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Uimacsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Uimacsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rimacsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Imac"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rimacsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rimacsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nserversp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Server"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nserversp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nserversp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Userversp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Server"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Userversp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Userversp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rserversp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Server"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rserversp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rserversp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nworkstationsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Workstation"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nworkstationsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nworkstationsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Uworkstationsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Workstation"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Uworkstationsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Uworkstationsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rworkstationsp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Refurb" AND type="Workstation"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rworkstationsp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rworkstationsp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Nmacbooksp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "New" AND type="Macbook"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Nmacbooksp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Nmacbooksp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Umacbooksp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
            $builder->select('masterlist.*')->orderBy('time', 'DESC');
            $builder->where('masterlist.conditions = "Used" AND type="Macbook"' );
          
        $users = $builder->get()->getResult();
      
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Umacbooksp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Umacbooksp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }

        public function Rmacbooksp()
        {
          $db      = \Config\Database::connect();
          $builder = $db->table('masterlist');
          $builder->select('masterlist.*')->orderBy('time', 'DESC');
          $builder->where('masterlist.conditions = "Refurb" AND type="Macbook"' );
          $users = $builder->get()->getResult();
        //   $users = $query->getResult();
        $idd = rand(1000, 9999);
        $fileName = 'Rmacbooksp'.$idd. '.xlsx';
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'CONDTIONS');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ASSETID');
        $sheet->setCellValue('E1', 'GEN');
        $sheet->setCellValue('F1', 'BRAND');
        $sheet->setCellValue('G1', 'SERIANO');
        $sheet->setCellValue('H1', 'PART');
        $sheet->setCellValue('I1', 'MODELID');
        $sheet->setCellValue('J1', 'MODEL');
        $sheet->setCellValue('K1', 'CPU');
        $sheet->setCellValue('L1', 'SPEED');
        $sheet->setCellValue('M1', 'RAM'); 
        $sheet->setCellValue('N1', 'HDD');
        $sheet->setCellValue('O1', 'ODD');
        $sheet->setCellValue('P1', 'SCREEN');
        $sheet->setCellValue('Q1', 'COMMENT');
        $sheet->setCellValue('R1', 'PRICE'); 
        $sheet->setCellValue('S1', 'CUSTOMER'); 
        $sheet->setCellValue('T1', 'LIST');      
        $sheet->setCellValue('U1', 'STATUS');      
        $sheet->setCellValue('V1', 'DATERECIEVERD');
        $sheet->setCellValue('W1', 'DATEDELIVERED');
      
        $rows = 2;
      
        foreach ($users as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->conditions);
            $sheet->setCellValue('C' . $rows, $val->type);
            $sheet->setCellValue('D' . $rows, $val->assetid);
            $sheet->setCellValue('E' . $rows, $val->gen);
            $sheet->setCellValue('F' . $rows, $val->brand);
            $sheet->setCellValue('G' . $rows, $val->serialno);
            $sheet->setCellValue('H' . $rows, $val->part);
            $sheet->setCellValue('I' . $rows, $val->modelid);
            $sheet->setCellValue('J' . $rows, $val->model);
            $sheet->setCellValue('K' . $rows, $val->cpu);
            $sheet->setCellValue('L' . $rows, $val->speed);
            $sheet->setCellValue('M' . $rows, $val->ram);
            $sheet->setCellValue('N' . $rows, $val->hdd);
            $sheet->setCellValue('O' . $rows, $val->odd);
            $sheet->setCellValue('P' . $rows, $val->screen);
            $sheet->setCellValue('Q' . $rows, $val->comment);
            $sheet->setCellValue('R' . $rows, $val->price);
            $sheet->setCellValue('S' . $rows, $val->customer);
            $sheet->setCellValue('T' . $rows, $val->list);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, $val->daterecieved);
            $sheet->setCellValue('W' . $rows, $val->datedelivered);
      
              $rows++;
          } 
      
            $data = [
                'ref' => $idd,
            ];
            $builder = $db->table("export");
            $builder = $db->table("export.*");
            $db->table('export')->insert($data);
          $writer = new Xlsx($spreadsheet);
          $writer->save("upload/".$fileName);
          $filename = "upload/".'Rmacbooksp'.$idd.".xlsx";
          return redirect()->to(base_url($filename));
      
        }


        // end


          // new spreadsheets for stock out
          public function Nimacsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "New" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Newimac'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Newimac'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uimacsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Used" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rimacsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Refurb" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nserversps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "New" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Userversps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Used" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Userversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Userversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rserversps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Refurb" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nworkstationsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "New" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uworkstationsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Used" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rworkstationsps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Refurb" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nmacbooksps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "New" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Umacbooksps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
              $builder->select('stockout.*')->orderBy('time', 'DESC');
              $builder->where('stockout.conditions = "Used" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Umacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Umacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rmacbooksps()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('stockout');
            $builder->select('stockout.*')->orderBy('time', 'DESC');
            $builder->where('stockout.conditions = "Refurb" AND type="Macbook"' );
            $users = $builder->get()->getResult();
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
  
          // end


          // new spreadsheets for faulty 
          public function Nimacspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "New" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Newimac'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Newimac'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uimacspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Used" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rimacspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Refurb" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nserverspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "New" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Userverspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Used" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Userversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Userversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rserverspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Refurb" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nworkstationspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "New" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uworkstationspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Used" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rworkstationspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Refurb" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nmacbookspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "New" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Umacbookspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
              $builder->select('faulty.*')->orderBy('time', 'DESC');
              $builder->where('faulty.conditions = "Used" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Umacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Umacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rmacbookspf()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faulty');
            $builder->select('faulty.*')->orderBy('time', 'DESC');
            $builder->where('faulty.conditions = "Refurb" AND type="Macbook"' );
            $users = $builder->get()->getResult();
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
  
          // end


          // new spreadsheets for faulty out 
          public function Nimacspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "New" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Newimac'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Newimac'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uimacspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Used" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rimacspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Refurb" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nserverspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "New" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Userverspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Used" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Userversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Userversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rserverspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Refurb" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nworkstationspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "New" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uworkstationspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Used" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rworkstationspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Refurb" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nmacbookspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "New" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Umacbookspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
              $builder->select('faultyout.*')->orderBy('time', 'DESC');
              $builder->where('faultyout.conditions = "Used" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Umacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Umacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rmacbookspfo()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('faultyout');
            $builder->select('faultyout.*')->orderBy('time', 'DESC');
            $builder->where('faultyout.conditions = "Refurb" AND type="Macbook"' );
            $users = $builder->get()->getResult();
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
  
          // end
  

          // new spreadsheets for warranty in 
          public function Nimacspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "New" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Newimac'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Newimac'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uimacspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Used" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rimacspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Refurb" AND type="Imac"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rimacsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rimacsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nserverspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "New" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Userverspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Used" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Userversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Userversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rserverspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Refurb" AND type="Server"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rserversp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rserversp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nworkstationspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "New" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Uworkstationspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Used" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Uworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Uworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rworkstationspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Refurb" AND type="Workstation"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rworkstationsp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rworkstationsp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Nmacbookspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "New" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Nmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Nmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Umacbookspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
              $builder->select('warrantyin.*')->orderBy('time', 'DESC');
              $builder->where('warrantyin.conditions = "Used" AND type="Macbook"' );
            
          $users = $builder->get()->getResult();
        
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Umacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Umacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  
          public function Rmacbookspw()
          {
            $db      = \Config\Database::connect();
            $builder = $db->table('warrantyin');
            $builder->select('warrantyin.*')->orderBy('time', 'DESC');
            $builder->where('warrantyin.conditions = "Refurb" AND type="Macbook"' );
            $users = $builder->get()->getResult();
          //   $users = $query->getResult();
          $idd = rand(1000, 9999);
          $fileName = 'Rmacbooksp'.$idd. '.xlsx';
        
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'Id');
          $sheet->setCellValue('B1', 'CONDTIONS');
          $sheet->setCellValue('C1', 'Type');
          $sheet->setCellValue('D1', 'ASSETID');
          $sheet->setCellValue('E1', 'GEN');
          $sheet->setCellValue('F1', 'BRAND');
          $sheet->setCellValue('G1', 'SERIANO');
          $sheet->setCellValue('H1', 'PART');
          $sheet->setCellValue('I1', 'MODELID');
          $sheet->setCellValue('J1', 'MODEL');
          $sheet->setCellValue('K1', 'CPU');
          $sheet->setCellValue('L1', 'SPEED');
          $sheet->setCellValue('M1', 'RAM'); 
          $sheet->setCellValue('N1', 'HDD');
          $sheet->setCellValue('O1', 'ODD');
          $sheet->setCellValue('P1', 'SCREEN');
          $sheet->setCellValue('Q1', 'COMMENT');
          $sheet->setCellValue('R1', 'PRICE'); 
          $sheet->setCellValue('S1', 'CUSTOMER'); 
          $sheet->setCellValue('T1', 'LIST');      
          $sheet->setCellValue('U1', 'STATUS');      
          $sheet->setCellValue('V1', 'DATERECIEVERD');
          $sheet->setCellValue('W1', 'DATEDELIVERED');
        
          $rows = 2;
        
          foreach ($users as $val){
              $sheet->setCellValue('A' . $rows, $val->id);
              $sheet->setCellValue('B' . $rows, $val->conditions);
              $sheet->setCellValue('C' . $rows, $val->type);
              $sheet->setCellValue('D' . $rows, $val->assetid);
              $sheet->setCellValue('E' . $rows, $val->gen);
              $sheet->setCellValue('F' . $rows, $val->brand);
              $sheet->setCellValue('G' . $rows, $val->serialno);
              $sheet->setCellValue('H' . $rows, $val->part);
              $sheet->setCellValue('I' . $rows, $val->modelid);
              $sheet->setCellValue('J' . $rows, $val->model);
              $sheet->setCellValue('K' . $rows, $val->cpu);
              $sheet->setCellValue('L' . $rows, $val->speed);
              $sheet->setCellValue('M' . $rows, $val->ram);
              $sheet->setCellValue('N' . $rows, $val->hdd);
              $sheet->setCellValue('O' . $rows, $val->odd);
              $sheet->setCellValue('P' . $rows, $val->screen);
              $sheet->setCellValue('Q' . $rows, $val->comment);
              $sheet->setCellValue('R' . $rows, $val->price);
              $sheet->setCellValue('S' . $rows, $val->customer);
              $sheet->setCellValue('T' . $rows, $val->list);
              $sheet->setCellValue('U' . $rows, $val->status);
              $sheet->setCellValue('V' . $rows, $val->daterecieved);
              $sheet->setCellValue('W' . $rows, $val->datedelivered);
        
                $rows++;
            } 
        
              $data = [
                  'ref' => $idd,
              ];
              $builder = $db->table("export");
              $builder = $db->table("export.*");
              $db->table('export')->insert($data);
            $writer = new Xlsx($spreadsheet);
            $writer->save("upload/".$fileName);
            $filename = "upload/".'Rmacbooksp'.$idd.".xlsx";
            return redirect()->to(base_url($filename));
        
          }
  

}