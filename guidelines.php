<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';

use Gender\Classes\UserAudit;
use Gender\Classes\Supports\Session;

auth_guard();

$user_audit = new UserAudit;

$user_audit->log(
    6, // Menu ID - Guidelines
    12 // Action ID - View
);

?>


<div class="container">

<h2 class="text-center">GENDER DICTIONARY</h2>

<!--REPORT BUTTONS-->
<div class="row" style="margin-bottom: 5px;">
    <div class="col-sm-3">
        <a href="#allies" type="submit" name="daily1" id="daily1" class="btn btn-primary form-control">Allies</a>
    </div>
    <div class="col-sm-3">
        <a href="#asexual" type="submit" name="weekly1" id="weekly1" class="btn btn-danger form-control">Asexual</a>
    </div>
    <div class="col-sm-3">
        <a href="#bisexuals" type="submit" name="monthly1" id="monthly1" class="btn btn-success form-control"></i>Bisexual</a>
    </div>
    <div class="col-sm-3">
        <a href="#female" type="submit" name="semi_annually1" id="semi_annually1" class="btn btn-warning form-control">Feminine</a>
    </div>
</div>

<div class="row" style="margin-bottom: 5px;">
    <div class="col-sm-3">
        <a  href="#gay" type="submit" name="daily1" id="daily1" class="btn btn-info form-control">Gay</a>
    </div>
    <div class="col-sm-3">
        <a href="#intersex" type="submit" name="weekly1" id="weekly1" class="btn btn-warning form-control">Intersex</a>
    </div>
    <div class="col-sm-3">
        <a href="#lesbian" type="submit" name="monthly1" id="monthly1" class="btn btn-primary form-control"></i>Lesbian</a>
    </div>
    <div class="col-sm-3">
        <a href="#male" type="submit" name="semi_annually1" id="semi_annually1" class="btn btn-danger form-control">Masculine</a>
    </div>
</div>

<div class="row" style="margin-bottom: 20px; ">
    <div class="col-sm-3">
        <a href="#pansexual"type="submit" name="daily1" id="daily1" class="btn btn-primary form-control">Pansexual</a>
    </div>
    <div class="col-sm-3">
        <a href="#queer" type="submit" name="weekly1" id="weekly1" class="btn btn-success form-control">Queer</a>
    </div>
    <div class="col-sm-3">
        <a href="#questioning" type="submit" name="daily1" id="daily1" class="btn btn-primary form-control">Questioning</a>
    </div>
    <div class="col-sm-3">
        <a href="#transgender" type="submit" name="weekly1" id="weekly1" class="btn btn-success form-control">Transgender</a>
    </div>
</div>
<!--REPORT BUTTONS END-->

<div class="row" style="text-align:center;">

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/allies.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="allies">
            <h3>Allies</h3>
            <p>A straight ally or heterosexual ally is a heterosexual and cisgender person who supports equal civil rights, gender equality, LGBT social movements, and challenges homophobia, biphobia and transphobia. Despite this, some people who meet this definition do not identify themselves as straight allies.</p>           
        </div>
    </div>


    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/asexual.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="asexual">
            <h3>Asexuality</h3>
            <p>Asexuality is the lack of sexual attraction to others, or low or absent interest in or desire for sexual activity. It may be considered the lack of a sexual orientation, or one of the variations thereof, alongside heterosexuality, homosexuality and bisexuality.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/bisexual.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="bisexuals">
            <h3>Bisexual</h3>
            <p>Sexually attracted to both men and women. Bisexuality is romantic attraction, sexual attraction, or sexual behavior toward both males and females, or romantic or sexual attraction to people of any sex or gender identity; this latter aspect is sometimes alternatively termed pansexuality.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3" id="female">
            <img src="../../assets/images/lgbt/female.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9">
            <h3>Feminine</h3>
            <p>Female (♀) is the sex of an organism, or a part of an organism, that produces non-mobile ova (egg cells). Barring rare medical conditions, most female mammals, including female humans, have two X chromosomes. Female characteristics vary between different species with some species containing more well defined female characteristics. Both genetics and environment shape the prenatal development of a female.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/gay.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="gay">
            <h3>Gay</h3>
            <p>A homosexual, especially a man. Gay is a term that primarily refers to a homosexual person or the trait of being homosexual. The term was originally used to mean "carefree", "cheerful", or "bright and showy".</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/intersex.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="intersex">
            <h3>Intersex</h3>
            <p>Intersex people are born with sex characteristics (including genitals, gonads and chromosome patterns) that do not fit typical binary notions of male or female bodies. ... the type of gonads—ovaries or testicles; the sex hormones; the internal reproductive anatomy (such as the uterus in females).</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/lesbian.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="lesbian">
            <h3>Lesbian</h3>
            <p>A lesbian is a homosexual woman. The word lesbian is also used to describe women in terms of their sexual identity or sexual behavior regardless of sexual orientation, or as an adjective to characterize or associate nouns with female homosexuality or same-sex attraction</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/male.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="male">
            <h3>Masculine</h3>
            <p>A male (♂) organism is the physiological sex that produces sperm. Each spermatozoon can fuse with a larger female gamete, or ovum, in the process of fertilization. A male cannot reproduce sexually without access to at least one ovum from a female, but some organisms can reproduce both sexually and asexually.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/pansexual.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="pansexual">
            <h3>Pansexual</h3>
            <p>Pansexuality, or omnisexuality, is the sexual, romantic or emotional attraction towards people regardless of their sex or gender identity. Pansexual people may refer to themselves as gender-blind, asserting that gender and sex are not determining factors in their romantic or sexual attraction to others.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/queer.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="queer">
            <h3>Queer</h3>
            <p>Queer is an umbrella term for sexual and gender minorities who are not heterosexual or cisgender. Originally meaning "strange" or "peculiar", queer came to be used pejoratively against those with same-sex desires or relationships in the late 19th century. Beginning in the late 1980s, queer scholars and activists began to reclaim the word to establish community and assert an identity distinct from the gay identity. People who reject traditional gender identities and seek a broader and deliberately ambiguous alternative to the label LGBT may describe themselves as queer.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/questioning.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="questioning">
            <h3>Questioning</h3>
            <p>The questioning of one's gender, sexual identity, sexual orientation, or all three is a process of exploration by people who may be unsure, still exploring, and concerned about applying a social label to themselves for various reasons.</p>           
        </div>
    </div>

    <div class="col-md-12 well well-md" style="display: inline-block; float: none; margin: 5px;">
        <div class="col-md-3">
            <img src="../../assets/images/lgbt/transgender.png" width="120px" height="120px">           
        </div>
        <div class="col-md-9" id="transgender">
            <h3>Transgender</h3>
            <p>Denoting or relating to a person whose sense of personal identity and gender does not correspond with their birth sex. Transgender people are sometimes called transsexual if they desire medical assistance to transition from one sex to another.</p>           
        </div>
    </div>
</div>

</div>

<?php 
include 'includes/scripts.php';
include 'includes/footer.php';
?>