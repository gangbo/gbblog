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
use constant { SERVICE_ID => '11', };

use Data::Dumper;

# 'http://www16.zzu.edu.cn/qtss/zzjpoem1.dll/query';

&main();

sub main {
    my $firstname_urls = &fetch_list_firstname();
    for my $firstname_url (@$firstname_urls) {
        print $firstname_url;
        &fetch_author_by_firstname($firstname_url);
        die;
    }

}

sub fetch_list_firstname {
    my $site_url = 'http://www16.zzu.edu.cn/qtss/zzjpoem1.dll/query';
    my $page_content
        = Spider->new( $site_url, 'post', { B5 => '诗人浏览' })
        ->fetch_page();
    ($page_content) = $page_content =~ m{td width="600">(.*?)</table>}gs;
    my @firstname_list = $page_content =~ m{<a href="(.*?)">}gs;
    return \@firstname_list;
}

sub fetch_author_by_firstname {
    my $url          = shift;
    my ($keyword) = $url=~ m{\?xing=(.*)}gs;
    my $page_content = Spider->new($url,undef,undef)->fetch_page();
    ($page_content) = $page_content=~ m{<td width="600">(.*?)</table>}gs;
    my @author_name = $page_content =~ m{(<a href=".*?">(.*?)</a>)}gs;
    #my $uref = new Unicode::UTF8simple;
    #    $_ =$uref->toUTF8("gb2312",$_);
    return \@author_name;
}

