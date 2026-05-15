<?php
class db{
function connection()
{
$db_host = "localhost";
$db_user= "root";
$db_password="";
$db_name="auction_system_g9";

$connection=  new mysqli($db_host, $db_user,$db_password,$db_name);
if($connection->connect_error)
    {
        die ("Could not Connect Database".$connection->connect_error);
    }
return $connection;
}

function CheckEmail($connection, $tablename, $email)
{
    $sql = "SELECT * FROM ".$tablename." WHERE email=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$email);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function signup($connection, $tablename, $name, $email, $phone, $bio, $password_hash)
{
    $role="buyer";
    $seller_verified=0;
    $sql= "INSERT INTO " .$tablename. "(name, email, phone, bio, password_hash, role, seller_verified) VALUES (?,?,?,?,?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("ssssssi",$name, $email, $phone, $bio, $password_hash, $role, $seller_verified);
    $result = $statement->execute();
    return $result;
}

function signin($connection, $tablename, $email)
{
    $sql = "SELECT * FROM ".$tablename." WHERE email=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$email);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function UserInfo($connection, $tablename, $id)
{
    $sql = "SELECT * FROM ".$tablename." WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function UpdateProfile($connection, $tablename, $id, $name, $phone, $bio)
{
    $sql= "UPDATE ".$tablename." SET name=?, phone=?, bio=? WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("sssi",$name, $phone, $bio, $id);
    $result = $statement->execute();
    return $result;
}

function CheckSellerRequest($connection, $tablename, $user_id)
{
    $sql = "SELECT * FROM ".$tablename." WHERE user_id=? ORDER BY id DESC LIMIT 1";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$user_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function SellerRequest($connection, $tablename, $user_id, $motivation)
{
    $status="pending";
    $sql= "INSERT INTO ".$tablename."(user_id, motivation, status) VALUES (?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("iss",$user_id, $motivation, $status);
    $result = $statement->execute();
    return $result;
}

function PendingSellerRequest($connection)
{
    $sql = "SELECT seller_requests.id AS request_id, seller_requests.user_id, seller_requests.motivation, seller_requests.status, seller_requests.created_at,
            users.name, users.email, users.phone, users.bio, users.seller_verified
            FROM seller_requests
            INNER JOIN users ON seller_requests.user_id=users.id
            WHERE seller_requests.status='pending' AND users.seller_verified=0
            ORDER BY seller_requests.created_at ASC";

    $statement=$connection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function ApproveSeller($connection, $user_id)
{
    $verified=1;
    $approved="approved";

    $sql1= "UPDATE users SET seller_verified=? WHERE id=?";
    $statement1=$connection->prepare($sql1);
    $statement1->bind_param("ii",$verified, $user_id);
    $result1 = $statement1->execute();

    $sql2= "UPDATE seller_requests SET status=? WHERE user_id=? AND status='pending'";
    $statement2=$connection->prepare($sql2);
    $statement2->bind_param("si",$approved, $user_id);
    $result2 = $statement2->execute();

    if($result1 && $result2)
        {
            return true;
        }
        else{
            return false;
        } 
}

function RejectSeller($connection, $user_id)
{
    $rejected="rejected";
    $sql= "UPDATE seller_requests SET status=? WHERE user_id=? AND status='pending'";
    $statement=$connection->prepare($sql);
    $statement->bind_param("si",$rejected, $user_id);
    $result = $statement->execute();
    return $result;
}




function AddCategory($connection, $name)
{
    $sql = "INSERT INTO categories(name) VALUES (?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$name);
    $result = $statement->execute();
    return $result;
}

function ShowCategory($connection)
{
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function UpdateCategory($connection, $id, $name)
{
    $sql = "UPDATE categories SET name=? WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("si",$name,$id);
    $result = $statement->execute();
    return $result;
}

function DeleteCategory($connection, $id)
{
    $sql = "DELETE FROM categories WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$id);
    $result = $statement->execute();
    return $result;
}

function CheckCategoryUsed($connection, $category_id)
{
    $sql = "SELECT COUNT(*) AS cnt FROM listings WHERE category_id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$category_id);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    return $row['cnt'];
}

function CreateListing($connection, $seller_id, $category_id, $title, $description, $starting_price, $reserve_price, $image_path, $end_datetime)
{
    $status = "active";
    $current_bid = $starting_price;
    $sql = "INSERT INTO listings(seller_id, category_id, title, description, starting_price, reserve_price, current_bid, image_path, end_datetime, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("iissdddsss",$seller_id,$category_id,$title,$description,$starting_price,$reserve_price,$current_bid,$image_path,$end_datetime,$status);
    $result = $statement->execute();
    return $result;
}

function ShowSellerListings($connection, $seller_id)
{
    $sql = "SELECT listings.*, categories.name AS category_name, COUNT(bids.id) AS bid_count FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN bids ON bids.listing_id=listings.id WHERE listings.seller_id=? GROUP BY listings.id ORDER BY listings.created_at DESC";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$seller_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function GetListingById($connection, $listing_id)
{
    $sql = "SELECT listings.*, categories.name AS category_name FROM listings LEFT JOIN categories ON listings.category_id=categories.id WHERE listings.id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$listing_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function CountBidsByListing($connection, $listing_id)
{
    $sql = "SELECT COUNT(*) AS cnt FROM bids WHERE listing_id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$listing_id);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    return $row['cnt'];
}

function UpdateListing($connection, $listing_id, $title, $description, $image_path)
{
    if($image_path != null)
        {
            $sql = "UPDATE listings SET title=?, description=?, image_path=? WHERE id=?";
            $statement=$connection->prepare($sql);
            $statement->bind_param("sssi",$title,$description,$image_path,$listing_id);
        }
    else
        {
            $sql = "UPDATE listings SET title=?, description=? WHERE id=?";
            $statement=$connection->prepare($sql);
            $statement->bind_param("ssi",$title,$description,$listing_id);
        }
    $result = $statement->execute();
    return $result;
}

function CancelListing($connection, $listing_id)
{
    $status = "cancelled";
    $sql = "UPDATE listings SET status=? WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("si",$status,$listing_id);
    $result = $statement->execute();
    return $result;
}



// Task 3 functions
function ShowActiveListings($connection)
{
    $sql = "SELECT listings.*, categories.name AS category_name, COUNT(bids.id) AS bid_count, users.name AS seller_name FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN bids ON bids.listing_id=listings.id LEFT JOIN users ON listings.seller_id=users.id WHERE listings.status='active' AND listings.end_datetime > NOW() GROUP BY listings.id ORDER BY listings.created_at DESC";
    $result = $connection->query($sql);
    return $result;
}
function SearchActiveListings($connection, $keyword)
{
    $kw = "%".$keyword."%";
    $sql = "SELECT listings.*, categories.name AS category_name, COUNT(bids.id) AS bid_count, users.name AS seller_name FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN bids ON bids.listing_id=listings.id LEFT JOIN users ON listings.seller_id=users.id WHERE listings.status='active' AND listings.end_datetime > NOW() AND listings.title LIKE ? GROUP BY listings.id ORDER BY listings.created_at DESC";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$kw);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function FilterListingsByCategory($connection, $category_id)
{
    $sql = "SELECT listings.*, categories.name AS category_name, COUNT(bids.id) AS bid_count, users.name AS seller_name FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN bids ON bids.listing_id=listings.id LEFT JOIN users ON listings.seller_id=users.id WHERE listings.status='active' AND listings.end_datetime > NOW() AND listings.category_id=? GROUP BY listings.id ORDER BY listings.created_at DESC";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$category_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function GetAuctionDetails($connection, $listing_id)
{
    $sql = "SELECT listings.*, categories.name AS category_name, users.name AS seller_name, users.email AS seller_email FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN users ON listings.seller_id=users.id WHERE listings.id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$listing_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function GetLastTenBids($connection, $listing_id)
{
    $sql = "SELECT bids.*, users.name AS bidder_name FROM bids LEFT JOIN users ON bids.buyer_id=users.id WHERE bids.listing_id=? ORDER BY bids.created_at DESC LIMIT 10";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$listing_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function PlaceBid($connection, $listing_id, $buyer_id, $amount)
{
    $sql = "INSERT INTO bids(listing_id, buyer_id, amount) VALUES (?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("iid",$listing_id,$buyer_id,$amount);
    $result = $statement->execute();
    return $result;
}

function UpdateCurrentBid($connection, $listing_id, $amount)
{
    $sql = "UPDATE listings SET current_bid=? WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("di",$amount,$listing_id);
    $result = $statement->execute();
    return $result;
}

function GetBidCount($connection, $listing_id)
{
    $sql = "SELECT COUNT(*) AS cnt FROM bids WHERE listing_id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$listing_id);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    return $row['cnt'];
}
 function GetMyBids($connection, $buyer_id)
{
    $sql = "SELECT listings.id AS listing_id, listings.title, listings.current_bid, listings.status, listings.end_datetime, listings.seller_id, listings.reserve_price, listings.winner_bid_id, MAX(bids.amount) AS my_highest_bid, seller.name AS seller_name, seller.email AS seller_email FROM bids LEFT JOIN listings ON bids.listing_id=listings.id LEFT JOIN users AS seller ON listings.seller_id=seller.id WHERE bids.buyer_id=? GROUP BY listings.id ORDER BY bids.created_at DESC";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$buyer_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

// Task 4 functions will be added here later.

function CloseExpiredAuctions($connection)
{
    $sql = "SELECT id FROM listings WHERE status='active' AND end_datetime <= NOW()";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    if($result && $result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
                {
                    $listing_id = $row['id'];
                    $stmt = $connection->prepare("SELECT id FROM bids WHERE listing_id=? ORDER BY amount DESC LIMIT 1");
                    $stmt->bind_param("i",$listing_id);
                    $stmt->execute();
                    $bidres = $stmt->get_result();
                    $winner_bid_id = null;
                    if($bidres->num_rows > 0)
                        {
                            $bidrow = $bidres->fetch_assoc();
                            $winner_bid_id = $bidrow['id'];
                        }
                    $upd = $connection->prepare("UPDATE listings SET status='ended', winner_bid_id=? WHERE id=? AND status='active'");
                    $upd->bind_param("ii",$winner_bid_id,$listing_id);
                    $upd->execute();
                }
        }
}

function GetSellerResults($connection, $seller_id)
{
    $sql = "SELECT listings.*, categories.name AS category_name, COUNT(bids.id) AS bid_count, winner_bid.amount AS winning_amount, winner_buyer.name AS winner_name, winner_buyer.email AS winner_email FROM listings LEFT JOIN categories ON listings.category_id=categories.id LEFT JOIN bids ON bids.listing_id=listings.id LEFT JOIN bids AS winner_bid ON listings.winner_bid_id=winner_bid.id LEFT JOIN users AS winner_buyer ON winner_bid.buyer_id=winner_buyer.id WHERE listings.seller_id=? GROUP BY listings.id ORDER BY listings.created_at DESC";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$seller_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

}
?>
