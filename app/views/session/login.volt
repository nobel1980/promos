{{ content() }}

<div class="col-md-4">
    <div id="signinform">
        {{ form('class': 'form-signin') }}
        <h2 class="form-signin-heading"><img width="105" height="75" alt="" src="image/promos-logo-op.png"></h2>
            {{ form.render('email') }}
            {{ form.render('password') }}

            <!--
            <div align="center" class="remember">
                {{ form.render('remember') }}
                {{ form.label('remember') }}
            </div>-->

            <!--<label class="checkbox">
              <input value="remember-me" type="checkbox"> মনে রেখ
            </label>-->

            {{ form.render('go') }}
            {{ form.render('csrf', ['value': security.getToken()]) }}
            <!--
            <hr>
            <div class="forgot">
                {{ link_to("session/forgotPassword", "পাসওয়ার্ড ভুলে গেছেন?") }}
            </div>-->
        </form>
    </div><!-- signinform -->
</div>