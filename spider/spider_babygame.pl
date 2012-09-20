#!/usr/bin/perl
use strict;
use warnings;
use LWP::UserAgent;
use File::Util;
use Digest::MD5 qw(md5 md5_hex md5_base64);
use Getopt::Long;
use Template;
use Template::Constants qw( :debug );
use FindBin;
use lib "$FindBin::Bin/libs";
use Spider;
use JSON;
use MyDB;
use constant { SERVICE_ID => '11', };

use Data::Dumper;

my $db_handle = undef;
my $config    = {
    INCLUDE_PATH => './tpl/',    # or list ref
    INTERPOLATE  => 1,           # expand "$var" in plain text
    POST_CHOMP   => 1,           # cleanup whitespace
         #    PRE_PROCESS  => 'header',    # prefix each template
    EVAL_PERL => 1,    # evaluate Perl code blocks
    OUTPUT_PATH => '../baby/public/html/kcollection/'
};
my @categories = (
    {   cid        => 1,
        cate_title => '0-1岁',
        name       => 'age_one',
    },
    {   cid        => 2,
        cate_title => '1-2岁',
        name       => 'age_two',
    },
    {   cid        => 3,
        cate_title => '2-3岁',
        name       => 'age_three',
    },
    {   cid        => 4,
        cate_title => '3-6岁',
        name       => 'age_four',
    },
);

&main;

sub main {
    my $articles_aref = &fetch_article_list;
    for (@$articles_aref) {
        my $article_ref = &fetch_detail_by_url( $_->{url} );
        $_->{detail} = $article_ref->{detail};
        $_->{title}  = $article_ref->{title};
    }
    $db_handle = &get_db_handle();
    $db_handle->prepare(
        'delete from kcollection_game where sid=' . SERVICE_ID )->execute();
    for (@$articles_aref) {
        my $insert_sql
            = 'REPLACE INTO kcollection_game set title=?,detail=?,type=?,cid=?,sid='
            . SERVICE_ID;
        $db_handle->prepare($insert_sql)
            ->execute( $_->{title}, $_->{detail}, $_->{age_type},
            $_->{game_type} );
        my $last_insert_id
            = $db_handle->last_insert_id( undef, undef,
            qw(kcollection_game id) )
            or die "no insert id?";
        $_->{id} = $last_insert_id;
    }
    my $template = Template->new($config);
    my $vars     = {
        categories    => \@categories,
        articles_aref => $articles_aref,
    };
    $template->process( 'baby_game.html', $vars, 'baby_game.html' )
        || die $template->error();
}

sub fetch_article_list {
    my $page_content
        = Spider->new('http://edu.pcbaby.com.cn/game/')->fetch_page();
    my @game_block
        = $page_content =~ m{<div class="video">\s*?(<dl>.*?)</div>}sg;

    my $age_type = 1;
    my @articles = ();
    for my $cate (@categories) {
        my @game_type = $game_block[ $age_type - 1 ] =~ m{<dl>.*?</dl>}gs;
        my @article_url_type = ();
        my $game_type_id     = 1;
        for my $type (@game_type) {
            my @article_url = $type =~ m{href="(http://edu\.pcbaby.*?)"}gs;
            for (@article_url) {
                push @articles,
                    {
                    url       => $_,
                    age_type  => $age_type,
                    game_type => $game_type_id,
                    };
            }
            $game_type_id++;
        }
        $cate->{article} = \@article_url_type;
        $age_type++;
    }
    return \@articles;
}

sub fetch_detail_by_url {
    my $url          = shift;
    my $page_content = Spider->new($url)->fetch_page();
    my ($title) = $page_content =~ m{class="ivy620">.*?<h1>(.*?)</h1>}gs;
    my ($detail)
        = $page_content
        =~ m{class="gameCenter">(.*?)<style type="text/css"}gs;
    my $detail_html  = '';
    for my $num (1..10){
        my ($detail_part) = $detail =~ m{"gPart$num">(.*?)</div>}gs;
        $detail_part =~ s{<.*?>| }{}gs;
        $detail_html .= "<p>$detail_part</p>" if defined $detail_part;
    }
    print "$detail_html \n\n";
    return {
        title  => $title,
        detail => $detail_html
    };
}

sub get_db_handle {
    return $db_handle if defined $db_handle;
    $db_handle = MyDB->db_conn('baby');
    $db_handle->prepare('set names utf8')->execute();
    return $db_handle;
}
