import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

class CatalogScreen extends StatelessWidget {
  const CatalogScreen({super.key});

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const CatalogScreen());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: buildAppBar(context),
      body: buildBody()
    );
  }

  Widget buildBody() {
    return Container(
      width: 375.w,
      height: 812.h,
      // padding: EdgeInsets.only(left:20.w, right: 20.w),
      color: Color(0xFFF2F4FA),
      child: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              padding: EdgeInsets.only(top: 60.h, bottom: 20.h, left:20.w, right: 20.w),
              child: Text(
                '天然無垢材を使ったマンションにフィットするオーダー家具をメーカーと共同で開発しました。あなたの日常にぴったりフィットする特別な空間をお楽しみください。',
                textAlign: TextAlign.justify,
                style: TextStyle(
                  color: Color(0xFF667185),
                  fontSize: 14,
                  fontFamily: 'SF Pro Display',
                  fontWeight: FontWeight.w400,
                ),
              ),
            ),
            SizedBox(
              width: 335.w,
              child: Row(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Container(
                    width: 24.w,
                    height: 20.w,
                    padding: const EdgeInsets.symmetric(horizontal: 1.67),
                    clipBehavior: Clip.antiAlias,
                    decoration: BoxDecoration(),
                    child: Image.asset("assets/images/catalog-icon.png"),
                  ),
                  const SizedBox(width: 10),
                  SizedBox(
                    width: 217.w,
                    child: Text(
                      'オーダー家具施工例',
                      style: TextStyle(
                        color: Color(0xFF101928),
                        fontSize: 16,
                        fontFamily: 'SF Pro Display',
                        fontWeight: FontWeight.w900,
                        // height: 0.10,
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 10),
            Container(
              padding:  EdgeInsets.only(
                top: 20,
                left: 20.w,
                right: 20.w,
                bottom: 40,
              ),
              decoration: BoxDecoration(color: Colors.white),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Container(
                          width: 335.w,
                          height: 236.h,
                          decoration: BoxDecoration(
                            image: DecorationImage(
                              image: NetworkImage(
                                  "https://via.placeholder.com/335x236"),
                              fit: BoxFit.fitWidth,
                            ),
                          ),
                        ),
                        Container(
                          width: double.infinity,
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              SizedBox(
                                width: double.infinity,
                                child: Text(
                                  'リビング（タイトルは20文字以内を想定）',
                                  style: TextStyle(
                                    color: Color(0xFF101928),
                                    fontSize: 16,
                                    fontFamily: 'SF Pro Display',
                                    fontWeight: FontWeight.w700,
                                    // height: 0,
                                  ),
                                ),
                              ),
                              const SizedBox(height: 12),
                              SizedBox(
                                width: double.infinity,
                                child: Text(
                                  '飾り棚にはスリムな埋込のライン照明と薄型ダウンライトの間接照明を配置し、照明の配線やエアコンの配管がみえないように配慮することで、すっきりした印象になるように計画しました。',
                                  style: TextStyle(
                                    color: Color(0xFF101928),
                                    fontSize: 12,
                                    fontFamily: 'SF Pro Display',
                                    fontWeight: FontWeight.w400,
                                    // height: 0.13,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 30),
                  Column(
                    mainAxisSize: MainAxisSize.min,
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Container(
                        width: 335.w,
                        height: 236.h,
                        decoration: BoxDecoration(
                          image: DecorationImage(
                            image: NetworkImage(
                                "https://via.placeholder.com/335x236"),
                            fit: BoxFit.fill,
                          ),
                        ),
                      ),
                      Container(
                        width: double.infinity,
                        height: 107,
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          mainAxisAlignment: MainAxisAlignment.start,
                          crossAxisAlignment: CrossAxisAlignment.center,
                          children: [
                            SizedBox(
                              width: double.infinity,
                              child: Text(
                                'リビング（タイトルは20文字以内を想定）',
                                style: TextStyle(
                                  color: Color(0xFF101928),
                                  fontSize: 16,
                                  fontFamily: 'SF Pro Display',
                                  fontWeight: FontWeight.w700,
                                  height: 0,
                                ),
                              ),
                            ),
                            const SizedBox(height: 12),
                            SizedBox(
                              width: double.infinity,
                              child: Text(
                                '飾り棚にはスリムな埋込のライン照明と薄型ダウンライトの間接照明を配置し、照明の配線やエアコンの配管がみえないように配慮することで、すっきりした印象になるように計画しました。',
                                style: TextStyle(
                                  color: Color(0xFF101928),
                                  fontSize: 12,
                                  fontFamily: 'SF Pro Display',
                                  fontWeight: FontWeight.w400,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            SizedBox(height: 80.h),
          ],
        ),
      ),
    );
  }

  AppBar buildAppBar(BuildContext context) {
    return AppBar(
      leading: IconButton(
        icon: Icon(Icons.arrow_back, color: Colors.black),
        onPressed: () => Navigator.of(context).pop(),
      ),
      backgroundColor: Colors.white,
      centerTitle: true,
      title: const Text(
        'オーダー家具',
        textAlign: TextAlign.center,
        style: TextStyle(
          color: Color(0xFF101928),
          fontSize: 16,
          fontFamily: 'SF Pro Display',
          fontWeight: FontWeight.w700,
          height: 0.10,
        ),
      ),
    );
  }
}
