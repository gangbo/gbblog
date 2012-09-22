#!/usr/bin/perl
use strict;
use warnings;
use LWP::UserAgent;
use URL::Encode qw/url_encode/;
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
use utf8;
use Unicode::UTF8simple;

use Data::Dumper;

# 'http://www16.zzu.edu.cn/qtss/zzjpoem1.dll/query';

&main();

sub main {
    my $url
        = 'http://www16.zzu.edu.cn/qtss/zzjpoem1.dll/shilist?qnam=%C0%EE%B0%D7%CA%AB%BC%AF&qs=5555543t3v2t7t6j3i0c7e0b3t3i';
    &fetch_works_by_author_url($url);

=x
    my $firstname_urls = &fetch_list_firstname();
    for my $firstname_url (@$firstname_urls) {
        print Dumper &fetch_author_by_firstname($firstname_url);
        die;
    }
=cut

}

sub fetch_list_firstname {
    my $site_url = 'http://www16.zzu.edu.cn/qtss/zzjpoem1.dll/query';
    my $page_content
        = Spider->new( $site_url, 'post', { B5 => '诗人浏览' } )
        ->fetch_page();
    ($page_content) = $page_content =~ m{td width="600">(.*?)</table>}gs;
    my @firstname_list = $page_content =~ m{<a href="(.*?)">}gs;
    return \@firstname_list;
}

sub fetch_author_by_firstname {
    my $url = shift;
    my ($keyword) = $url =~ m{\?xing=(.*)}gs;
    my $page_content = Spider->new( $url, undef, undef )->fetch_page();
    ($page_content) = $page_content =~ m{<td width="600">(.*?)</table>}gs;
    my @author_name = $page_content =~ m{<a href="(.*?)">(.*?)</a>}gs;
    my $uref = new Unicode::UTF8simple;

    #    $_ =$uref->toUTF8("gb2312",$_);
    my $i = -1;
    my @author_arr;
    for ( my $i = 0; $i < scalar @author_name; $i++ ) {
        push @author_arr,
            {
            url  => $author_name[$i],
            name => $uref->toUTF8( 'gb2312', $author_name[ ++$i ] )
            };
    }

#    my @author_arr = map { $i++; {name=>$_[$i],url=>$_[$i+1]} } @author_name;
    return \@author_arr;
}

sub fetch_works_by_author_url {
    my $works_list_url = shift;
    my $page_content   = Spider->new($works_list_url)->fetch_page();
    my @all_work_urls;
    #是否是多页
    my $max_pages = &_mulity_page($page_content) || 1;
    for ( 1 .. $max_pages ) {
        $page_content = Spider->new("$works_list_url&pn=$_")->fetch_page()
            if ( $_ != 1 );
        ($page_content)
            = $page_content
            =~ m{bordercolor="#F8C84B" width="100%">(.*?)</table>}gs;
        my @urls = $page_content =~ m{href="(.*?)"}gs;
        push @all_work_urls,@urls; 
    }
    return \@all_work_urls;
}

sub _mulity_page {
    my $page_content = shift;
    ($page_content)
        = $page_content =~ m{<td height="20" width="315">(.*?)</td>}gs;
    my $uref = new Unicode::UTF8simple;
    $page_content = $uref->toUTF8( 'gb2312', $page_content );
    my $pattern = '分(.*?)页';
    utf8::encode($pattern);
    my ($pages) = $page_content =~ m{$pattern}gs;
    return $pages;
}

