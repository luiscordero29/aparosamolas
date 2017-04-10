                            <?php 
                            if (!empty($alert['success'])) {
                            foreach ($alert['success'] as $key => $value) { 
                            ?>                            
                                <p class="alert alert-success"><?php echo $value; ?></p>
                            <?php 
                                }} 
                            ?>

                            <?php 
                            if (!empty($alert['info'])) {
                            foreach ($alert['info'] as $key => $value) { ?>                            
                                <p class="alert alert-info"><?php echo $value; ?></p>
                            <?php 
                                }} 
                            ?>

                            <?php 
                            if (!empty($alert['warning'])) {
                            foreach ($alert['warning'] as $key => $value) { 
                            ?>                            
                                <p class="alert alert-warning"><?php echo $value; ?></p>
                            <?php 
                                }} 
                            ?>

                            <?php 
                            if (!empty($alert['danger'])) {
                            foreach ($alert['danger'] as $key => $value) { 
                            ?>                            
                                <p class="alert alert-danger"><?php echo $value; ?></p>
                            <?php 
                                }} 
                            ?>