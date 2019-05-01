<div class="bc-container-fluid py-4 upload-section upload-section-size">
      <div class="row final-step">
          <div class="col-md-7 text-center">
              <div class="row">
                    <?php
                        $size_terms = get_terms( 'pa_size' );
                        if(!empty($size_terms)):
                            foreach($size_terms as $st_index => $st):
                    ?>
                    <div data-size="<?= $st->name ?>" class="size-previews col-md-6 col-12 <?=$uploadstore->getColSize(strtolower($st->name)) ?> mb-2 is-selectable small-col <?php if($st_index == 0): ?>active<?php endif; ?>">
                        <div>
                            <div class="preview">
                                <img class="img-size-preview" alt="">
                            </div>
                            <p class="title uppercase weight-600"><?= $st->name ?></p>
                            <?php the_field("preview_box_decription", $st); ?>

                        </div>
                    </div>
                  <?php endforeach;
                    endif; ?>
                    <?
              ?>

              </div>
          </div>
          <div class="col-md-5 pt-5 px-2">
            <h2 class="weight-700 text-secondary mb-3">Select a size</h2>
              <?php woocommerce_template_single_add_to_cart(); ?>
          </div>

      </div>
</div>
