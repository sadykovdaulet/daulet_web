<div class="row">
    <div class="col border col-10 col-sm-6">
        <form method="post" action="includes/addScheduleItem.php">
            <fieldset >
                <legend>Добавить занятие</legend>
                <div class="form-group">
                    <label for="day">Дата</label>
                    <input type="date" class="form-control" name="day" required>
                </div>
                <div class="form-group">
                    <label>№ пары</label>
                    <select type="" class="form-control" name="lesson_id">
                        <?php
                        foreach ($lessons as $lesson){
                            echo"<option >{$lesson['id']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Класс</label>
                    <select type="" class="form-control" name="class_id">
                        <?php
                        foreach ($classes as $class){
                            echo"<option value='{$class['id']}'>{$class['place']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Дисциплина</label>
                    <select type="" class="form-control" name="discipline_id">
                        <?php
                        foreach ($disciplines as $discipline){
                            echo"<option value='{$discipline['id']}'>{$discipline['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Группа</label>
                    <select type="" class="form-control" name="group_id">
                        <?php
                        foreach ($groups as $group){
                            echo"<option value='{$group['id']}'>{$group['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Преподаватель</label>
                    <select type="" class="form-control" name="tutor_id">
                        <?php
                        foreach ($tutors as $tutor){
                            echo"<option value='{$tutor['id']}'>{$tutor['secondName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </fieldset>

        </form>
    </div>
    <div class="col col-2 col-sm-6"></div>
</div>
