<div class="products">
    <div class="box-container">
            <?php
            $select_services = $conn->prepare("SELECT * FROM `services` WHERE status = ? LIMIT 6");
            $select_services->execute(['active']);
            if ($select_services->rowCount() > 0) {
                while ($fetch_services = $select_services->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_files/<?= $fetch_services['image']; ?>" class="image">
                
                <div class="content">
                    <div class="button">
                        <div>
                            <h3 class="name"><?= $fetch_services['name']; ?></h3>
                        </div>
                        <div>
                            <a href="view_services.php?sid=<?= $fetch_services['id']; ?>" class="bx bx-show"></a>
                        </div>
                    </div>
                    <p class="price">Price: ₹<?= $fetch_services['price']; ?>/-</p>
                    <input type="hidden" name="service_id" value="<?= $fetch_services['id']; ?>">
                    <div class="flex-btn">
                        <a href="book_appointment.php?get_id=<?= $fetch_services['id']; ?>" class="btn">Book Appointment</a>
                    </div>
                </div>
            </form>
            <?php
                }
            } else {
                echo '<div class="empty">
                    <p>No Services Added Yet!</p>
                    </div>';
            }
            ?>
        </div>
    </div>