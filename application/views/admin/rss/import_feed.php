<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('import_rss_feed'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>feeds" class="btn btn-success btn-add-new">
                        <i class="fa fa-bars"></i>
                        <?php echo trans('rss_feeds'); ?>
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('rss_controller/import_feed_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans("feed_name"); ?></label>
                    <input type="text" class="form-control" name="feed_name" placeholder="<?php echo trans("feed_name"); ?>"
                           value="<?php echo old('feed_name'); ?>" maxlength="400" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("feed_url"); ?></label>
                    <input type="text" class="form-control" name="feed_url" placeholder="<?php echo trans("feed_url"); ?>"
                           value="<?php echo old('feed_url'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("number_of_posts_import"); ?></label>
                    <input type="number" class="form-control max-600" name="post_limit" placeholder="<?php echo trans("number_of_posts_import"); ?>"
                           value="<?php echo old('post_limit'); ?>" min="1" max="500" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control max-600" onchange="get_categories_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('category'); ?></label>
                    <select id="categories" name="category_id" class="form-control max-600" onchange="get_sub_categories(this.value);" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($top_categories as $item): ?>
                            <?php if ($item->id == old('category_id')): ?>
                                <option value="<?php echo html_escape($item->id); ?>"
                                        selected><?php echo html_escape($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('subcategory'); ?></label>
                    <select id="subcategories" name="subcategory_id" class="form-control max-600">
                        <option value="0"><?php echo trans('select_category'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('auto_update'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="auto_update" value="1" id="auto_update_enabled" class="square-purple" checked>
                            <label for="auto_update_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="auto_update" value="0" id="auto_update_disabled" class="square-purple">
                            <label for="auto_update_disabled" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_read_more_button'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="read_more_button" value="1" id="read_more_button_enabled" class="square-purple" checked>
                            <label for="read_more_button_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="read_more_button" value="0" id="read_more_button_disabled" class="square-purple">
                            <label for="read_more_button_disabled" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('add_posts_as_draft'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="add_posts_as_draft" value="1" id="add_posts_as_draft_1" class="square-purple">
                            <label for="add_posts_as_draft_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="add_posts_as_draft" value="0" id="add_posts_as_draft_2" class="square-purple" checked>
                            <label for="add_posts_as_draft_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo trans("read_more_button_text"); ?></label>
                    <input type="text" class="form-control max-600" name="read_more_button_text" placeholder="<?php echo trans("read_more_button_text"); ?>"
                           value="Read More" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?>&nbsp;(<?php echo trans("optional"); ?>)</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class='btn btn-sm bg-purple btn-file-upload'>
                                <?php echo trans('select_image'); ?>
                                <input type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif">
                            </a>
                            <a class='btn btn-sm bg-gray file-reset-button m-l-5' id="Multifileupload_button" onclick="reset_preview_image('#Multifileupload');"><?php echo trans('reset'); ?></a>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <div id="MultidvPreview">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('import_rss_feed'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
