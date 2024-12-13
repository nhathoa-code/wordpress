<?php

require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class Booking_History_Table_List extends WP_List_Table {

    private $table_data;

    public function __construct() {
        parent::__construct([
            'singular' => 'custom_item',
            'plural'   => 'custom_items',
            'ajax'     => false,
        ]);
        $this->handle_action();
    }

    public function handle_action() {
        if(isset($_GET["action"]) && $_GET["action"] == "delete"){
            global $wpdb;
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'delete_item_' . $id)) {
                wp_die('Security check failed.');
            }
            $table_name = $wpdb->prefix . 'vnh_booking_history';
            $wpdb->delete($table_name, ['ID' => $id], ['%d']);
        }
    }

    public function get_columns() {
        return [
            'cb'     => '<input type="checkbox" />',
            'g_name' => 'Guest\'s Info',
            'room_type' => 'Room Type',
            'hotel' => "Hotel",
            'check_in' => 'Check in',
            'check_out' => 'Check out',
            'log' => 'Log',
            'room_no' => "Room No"
        ];
    }

    protected function get_sortable_columns() {
        $sortable_columns = array(
            'check_in'  => array('check_in', false),
            'check_out' => array('check_out', false),
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
            $actions = array(
                    'delete_all' => __('Delete', 'supporthost-admin-table')
            );
            return $actions;
    }

    public function extra_tablenav($which) {
        if ($which === 'top') {
            include_once plugin_dir_path( dirname( __FILE__ ) ) . 'models/Post.php';
            $post = new Post();
            $hotels = $post->getHotels();
            ?>
            <div class="alignleft actions">
                <label for="filter-status" class="screen-reader-text">Filter by Hotel</label>
                <select name="hotel" id="filter-status">
                    <option value="">All Hotels</option>
                    <?php foreach($hotels as $h): ?>
                        <option <?php selected($h->ID,$_GET["hotel"] ?? null) ?> value="<?php echo $h->ID; ?>"><?php echo $h->post_title; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="">From:</label>
                <input type="date" name="from-date" value="<?php echo $_GET['from-date'] ?? ""; ?>" placeholder="from date">
                <label for="">To:</label>
                <input type="date" name="to-date" value="<?php echo $_GET['to-date'] ?? ""; ?>" placeholder="to date">
                <label for="filter-category" class="screen-reader-text">Filter by Category</label>
                <select name="filter-by-date" id="filter-category">
                    <option value="">None</option>
                    <option <?php selected($_GET['filter-by-date'] ?? null,"check-in") ?> value="check-in">Check In</option>
                    <option <?php selected($_GET['filter-by-date'] ?? null,"check-out") ?> value="check-out">Check Out</option>
                </select>
                <button type="submit" name="filter_action" id="post-query-submit" class="button">Filter</button>
            </div>
            <?php
        }
    }

    function usort_reorder($a, $b) {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'ID';
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        $result = strcmp($a[$orderby], $b[$orderby]);
        return ($order === 'asc') ? $result : -$result;
    }

    protected function column_cb($item) {
        return sprintf('<input type="checkbox" name="post[]" value="%s" />', $item['ID']);
    }

    protected function column_log($item) {
        $log = unserialize($item['log']);
    ?>
        <ul style="margin:0">
            <?php foreach($log as $item): ?>
                <li>
                    <span style="font-weight: 500;"><?php echo "{$item['event']}"; ?></span>
                    <br>
                    <?php echo "{$item['date-time']}"; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    }

    protected function column_room_no($item) {
        $room_no = unserialize($item['room_no']);
    ?>
        <ul style="margin:0">
            <?php foreach($room_no as $index => $item): $room = $index + 1;?>
                <li>
                    <?php echo "Phòng {$room}: "; ?>
                    <span style="font-weight: 500;"><?php echo $item; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    }

    function column_hotel($item) {
        $hotel = get_post($item["hotel"]);
        echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($hotel->ID),$hotel->post_title);
    }

    function column_room_type($item) {
        $hotel = get_post($item["room_type"]);
        echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($hotel->ID),$hotel->post_title);
    }

    function column_g_name($item) {
        $delete_url = add_query_arg([
            'post_type' => 'vnh_booking',
            'page'    => $_GET['page'],
            'action'  => 'delete',
            'id' => $item['ID'],
            '_wpnonce' => wp_create_nonce('delete_item_' . $item['ID']),
        ], admin_url('edit.php'));
        $actions = array(
            'delete' => sprintf('<a href="%s">' . 'Delete' . '</a>', $delete_url),
        );
        $str = "<div>{$item["g_name"]}</div>";
        $str .= "<div>{$item["g_email"]}</div>";
        $str .= "<div>{$item["g_phone"]}</div>";
        return sprintf('%1$s %2$s', $str, $this->row_actions($actions));
    }

    protected function column_default($item, $column_name) {
        return $item[$column_name];
    }

    private function get_data($per_page) {
        global $wpdb;
        $args = array();
        $table_name = $wpdb->prefix . 'vnh_booking_history';
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;
        $query = "SELECT * FROM $table_name";
        if(isset($_GET["hotel"]) && !empty($_GET['hotel'])){
            $query .= " WHERE hotel = {$_GET['hotel']}";
            $hotel_query = true;
        }
        if(isset($_GET['filter-by-date']) && !empty($_GET['filter-by-date'])){
            if(!empty($_GET['from-date']) && !empty($_GET['to-date'])){
                $query .= (isset($hotel_query) ? " AND " : " WHERE ") . ($_GET['filter-by-date'] == 'check-in' ? "check_in" : "check_out") . " BETWEEN %s AND %s";
                $args[] = $_GET['from-date'];
                $args[] = $_GET['to-date'];
                $filter_by_date_query = true;
            }
        }
        if(isset($_GET["s"]) && !empty($_GET['s'])){
            $query .= (isset($hotel_query) || isset($filter_by_date_query) ? " AND " : " WHERE ") . "(g_name LIKE %s OR g_email LIKE %s OR g_phone LIKE %s)";
            $search = "%" . $wpdb->esc_like($_GET['s']) . "%";
            $args[] = $search;
            $args[] = $search;
            $args[] = $search;
        }
        $query_count = str_replace("*","COUNT(*)",$query);
        $total_items = $wpdb->get_var($wpdb->prepare($query_count,$args));
        $this->set_pagination($per_page,$total_items);
        $query .= " LIMIT %d OFFSET %d";
        $args[] = $per_page;
        $args[] = $offset;
        $items = $wpdb->get_results($wpdb->prepare($query,$args), ARRAY_A);
        return $items;
    }

    private function set_pagination($per_page,$total_items) {
        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);
    }

    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = ( is_array(get_user_meta( get_current_user_id(), 'managetoplevel_page_supporthost_list_tablecolumnshidden', true)) ) ? get_user_meta( get_current_user_id(), 'managetoplevel_page_supporthost_list_tablecolumnshidden', true) : array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->table_data = $this->get_data(5);
        usort($this->table_data, array(&$this, 'usort_reorder'));
        $this->items = $this->table_data;
    }
}