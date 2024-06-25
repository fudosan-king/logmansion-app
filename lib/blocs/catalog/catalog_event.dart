import 'package:equatable/equatable.dart';

abstract class CatalogEvent extends Equatable {
  const CatalogEvent();

  @override
  List<Object> get props => [];
}

class FetchCatalogs extends CatalogEvent {}

class RefreshCatalogs extends CatalogEvent {}
