import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../blocs/catalog/catalog_bloc.dart';
import '../../blocs/catalog/catalog_event.dart';
import '../../blocs/catalog/catalog_state.dart';
import '../../lang/app_strings.dart';
import '../../repositories/catalog_repository.dart';
import 'catalog_item.dart';

class CatalogScreen extends StatelessWidget {
  const CatalogScreen({super.key});

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const CatalogScreen());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: buildAppBar(context),
      body: BlocProvider(
          create: (context) =>
          CatalogBloc(CatalogRepository())
            ..add(FetchCatalogs()),
          child: buildBody()),
    );
  }

  AppBar buildAppBar(BuildContext context) {
    return AppBar(
      // leading: IconButton(
      //   icon: const Icon(Icons.arrow_back, color: Colors.black),
      //   onPressed: () => Navigator.of(context).pop(),
      // ),
      automaticallyImplyLeading: false,
      backgroundColor: Colors.white,
      centerTitle: true,
      title: const Text(
        AppStrings.furniture,
        textAlign: TextAlign.center,
        style: TextStyle(
          color: Color(0xFF101928),
          fontSize: 16,
          fontFamily: 'SF Pro Display',
          fontWeight: FontWeight.w700,
        ),
      ),
      actions: [
        IconButton(
          icon: const Icon(Icons.close, color: Colors.black),
          onPressed: () => Navigator.of(context).pop(),
        ),
      ],
    );
  }

  Widget buildBody() {
    return BlocBuilder<CatalogBloc, CatalogState>(
      builder: (context, state) {
        if (state is CatalogLoading) {
          return const Center(child: CircularProgressIndicator());
        } else if (state is CatalogLoaded) {
          return RefreshIndicator(
            onRefresh: () async {
              context.read<CatalogBloc>().add(RefreshCatalogs());
            },
            child: Container(
            width: 375.w,
            height: 812.h,
            color: const Color(0xFFF2F4FA),
            child: SingleChildScrollView(
              child: Column(
                children: [
                  Container(
                    padding: EdgeInsets.only(
                        top: 60.h, bottom: 20.h, left: 20.w, right: 20.w),
                    child: const Text(
                      AppStrings.furnitureDescription,
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
                          decoration: const BoxDecoration(),
                          child: Image.asset("assets/images/catalog-icon.png"),
                        ),
                        const SizedBox(width: 10),
                        SizedBox(
                          width: 217.w,
                          child: const Text(
                            AppStrings.furnitureExamples,
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
                    padding: EdgeInsets.only(
                      top: 20.h,
                      left: 20.w,
                      right: 20.w,
                    ),
                    decoration: const BoxDecoration(color: Colors.white),
            
                    child: ListView.builder(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: state.catalogs.length,
                      itemBuilder: (context, index) {
                        final catalog = state.catalogs[index];
                        return CatalogItem(catalog: catalog);
                      },
                    ),
                  ),
                  SizedBox(height: 80.h),
                ],
              ),
            ),
                    ),
          );
        } else if (state is CatalogError) {
          return Center(child: Text('Error: ${state.message}'));
        } else {
          return const Center(child: Text('Press button to fetch catalogs'));
        }

      },
    );
  }
}
